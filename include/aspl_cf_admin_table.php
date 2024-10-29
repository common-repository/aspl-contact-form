<?php
 if ( ! defined( 'ABSPATH' ) ) 
    {
        exit;
    }
    
    if(!class_exists('WP_List_Table')){
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    class aspl_woocommerce_daily_deals_List_Table extends WP_List_Table {

            function __construct(){
              global $status, $page;
                    
              parent::__construct( array(
                  'singular'=> 'id',     //singular name of the listed records
                  'plural'  => 'ids',    //plural name of the listed records
                  'ajax'    => false     //does this table support ajax?
              ) );
            }

            function table_data1(){
                global $wpdb;
                $table_name = $wpdb->prefix . "aspl_cf_form_data";
                $question12 = $wpdb->get_results("SELECT * FROM $table_name");

                $admin_data = array();
                $admin_data1 = array();
                foreach ($question12 as $temp) {    
                    $template_shortcode = '[aspl-contact-form text="'.$temp->template_shortcode.'"]'; 
                    $admin_data['template_id']       = $temp->template_id;
                    $admin_data['template_title']    = $temp->template_title;
                    $admin_data['template_shortcode']= $template_shortcode;
                    $admin_data['template_date']     = $temp->template_date;
                    $admin_data['template_field_data']= $temp->template_field_data;

                    $admin_data1[]= $admin_data;    
                }
                return $admin_data1;
            }

            function column_default($item, $column_name){
                switch($column_name){
                    case 'template_title':
                    case 'template_shortcode':
                    case 'template_date':
                        return $item[$column_name];
                    default:
                        return print_r($item,true); //Show the whole array for troubleshooting purposes
                }
            }

            function column_template_title($item){
                $page_na = 'aspl_contact_form_add';
                $actions = array(
                    'id' => sprintf('<span style="color:silver">(id:%1$s)</span>',$item['template_id']),
                    'edit'      => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>',$page_na,'edit',$item['template_id']),
                );
                return sprintf('%1$s %2$s',$item['template_title'],$this->row_actions($actions));
            }

            function column_cb($item){
                return sprintf(
                    '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                    /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
                    /*$2%s*/ $item['template_id']            //The value of the checkbox should be the record's id
                );
            }

            function get_columns(){
                $columns = array(
                    'cb'            => '<input type="checkbox" />', //Render a checkbox instead of text
                    'template_title'      => 'Title',
                    'template_shortcode'=> 'Shortcode',
                    'template_date'  => 'Create At',
                );
                return $columns;
            }

            function get_sortable_columns() {
                $sortable_columns = array(
                    'template_title'     => array('template_title',false),     //true means it's already sorted
                    'template_shortcode'    => array('template_shortcode',false),
                    'template_date'        => array('template_date',false)
                );
                return $sortable_columns;
            }

            function get_bulk_actions() {
                $actions = array(
                    'delete'    => 'Delete',
                );
                return $actions;
            }

            function process_bulk_action() {
                
                //Detect when a bulk action is being triggered...
                if( 'delete'===$this->current_action() ) {
                    // var_dump($_POST['id']);
                    $tr = array_map( 'sanitize_text_field', $_POST['id'] );
                    global $wpdb;
                    $table_name = $wpdb->prefix . "aspl_cf_form_data";
                    foreach ($tr as $key23) {

                                $wpdb->query( $wpdb->prepare( "DELETE FROM $table_name WHERE template_id = %s", $key23 ) );
                    }
                }
            }

            function prepare_items() {
                global $wpdb;     //This is used only if making any database queries

                $per_page = 10;

                $columns = $this->get_columns();
                $hidden = array();
                $sortable = $this->get_sortable_columns();
              
                $user = get_current_user_id();
                $screen = get_current_screen();
                $screen_option = $screen->get_option('per_page', 'option');

                $per_page = get_user_meta($user, $screen_option, true);
                if ( empty ( $per_page) || $per_page < 1 ) {
                    $per_page = $screen->get_option( 'per_page', 'default' );
                }
              
                $this->_column_headers = array($columns, $hidden, $sortable);
                $this->process_bulk_action();
                $data = $this->table_data1(); 

                    /*$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'template_title'; //If no sort, default to title
                    $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
                    $result = strcmp($a[$orderby], $b[$orderby]);   //Determine sort order
                    return ($order==='asc') ? $result : -$result;   //Send final sort direction to usort*/



                function usort_reorder($a,$b){
                        if ( (!empty($_REQUEST['orderby'])) && (!empty($_REQUEST['order'])) ) {
                                
                                $request_orderby = sanitize_text_field($_REQUEST['orderby']);
                                $request_order = sanitize_text_field($_REQUEST['order']);
                                $orderby = (!empty($request_orderby)) ? $request_orderby : 'template_title'; //If no sort, default to title
                                $order = (!empty($request_order)) ? $request_order : 'asc'; //If no order, default to asc
                                $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
                                return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
                        
                        }


                }
                usort($data, 'usort_reorder');
            
                $current_page = $this->get_pagenum(); 
                $total_items = count($data);
                $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
              
                $this->items = $data;
                $this->set_pagination_args( array(
                        'total_items' => $total_items,  //WE have to calculate the total number of items
                        'per_page'    => $per_page, //WE have to determine how many items to show on a page
                        'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
                        ) 
                    );
            }

    }

?>