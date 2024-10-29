<?php 
/*Plugin Name: ASPL Contact Form
	Description: ASPL Contact Form is just another contact form plugin which makes it fast and easy to capture visitor information right from your WordPress site.
	Author: acespritech
	Author URI: https://acespritech.com/
	Version: 1.1.0
	Domain Path: /languages/
	License: GPLv2 or later
 	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*Database Installer Hook*/
	function aspl_cf_installer(){
	    include('include/aspl_cf_db.php');
	}
	register_activation_hook( __file__, 'aspl_cf_installer' );
/*End*/

/*Load User Side Script and Style*/
	function aspl_cf_user_load_scripts($hook) {
	    wp_enqueue_script("jquery");
	    wp_enqueue_script( 'aspl_cf_user_js', plugin_dir_url(__FILE__) . 'js/aspl_cf_custom_user_js.js', array('jquery'), '', true); 
	    wp_enqueue_style('aspl_cf_user_css', plugin_dir_url(__FILE__) . 'css/aspl_cf_custom_user_css.css');
	}
	add_action('wp_enqueue_scripts', 'aspl_cf_user_load_scripts');
/* End Load User Side Script and Style */

/* Load Admin Side Script and Style */
    function aspl_cf_admin_load_scripts($hook) {
        wp_enqueue_script("jquery");
        wp_enqueue_script( 'wdd_custom_js', plugin_dir_url(__FILE__) . 'js/aspl_cf_custom_admin_js.js', array('jquery'), '', true); 
        wp_enqueue_style('wdd_custom_css', plugin_dir_url(__FILE__) . 'css/aspl_cf_custom_admin_css.css');
    }
    add_action('admin_enqueue_scripts', 'aspl_cf_admin_load_scripts');
/* End Load Admin Side Script and Style */

/* Add Admin Menu */
 	add_action('admin_menu', 'aspl_cf_admin_menu_page' , 9, 0 );
    function aspl_cf_admin_menu_page(){
    	
    	global $_wp_last_object_menu;
		$_wp_last_object_menu++;
        
        /* Woocommerce Daily Deals Menu Page */
        $hook = add_menu_page('Aspl-Contact', 'Contact', 'manage_options', 'aspl_contact_form', 'aspl_cf_main_page_callback_fun','dashicons-email-alt',$_wp_last_object_menu);
        
        /* Sub-menu Page Add Daily Deals */
        add_submenu_page( 'aspl_contact_form', 'New', 'New','manage_options', 'aspl_contact_form_add','aspl_cf_add_new_callback_fun');
        // add_submenu_page( 'aspl_contact_form', 'Setting', 'Setting','manage_options', 'aspl_contact_form_setting','aspl_cf_setting_callback_fun');

        add_action( "load-$hook", 'aspl_add_wdd_options' );

    }

    /* Admin List Table Pagination callback */
        function aspl_add_wdd_options() {
            global $wdd_List_Table;
            $option = 'per_page';
            $args = array(
                       'label' => 'Contact-Form',
                        'default' => 10,
                        'option' => 'deals_per_page'
                    );
            add_screen_option( $option, $args );
        }

        function aspl_wdd_set_screen_option($status, $option, $value)
        {
            if ( 'deals_per_page' == $option ) return $value;
        }
        add_filter('set-screen-option', 'aspl_wdd_set_screen_option', 10, 3);
    
    /* End Admin List Table Pagination callback */

/*End Menu Pages Function Callback*/

	function aspl_cf_main_page_callback_fun(){
		include 'include/aspl_cf_admin_table.php';
		$feedbacklisttable = new aspl_woocommerce_daily_deals_List_Table();
		?>
		<div class="wrap">
		<h1 class="wp-heading-inline">Forms <span class="dashicons-before dashicons-email-alt"></span>
			<a href="?page=aspl_contact_form_add" class="page-title-action">Add New</a>
		</h1>
		
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php
							$feedbacklisttable->prepare_items();
							$feedbacklisttable->display(); ?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
		</div>
		<?php
	}

	function aspl_cf_add_new_callback_fun(){
		
		include 'include/aspl_cf_add_new.php';

	}

	function aspl_cf_setting_callback_fun(){

		include 'include/setting.php';
	
	}

/*End Menu Pages Function Callback*/


/*Create a ShortCode*/

	// [footag foo="bar"] [footag foo="3"]

	function aspl_cf_footag_func( $attr ) { 
		global $wpdb;
		$table_name = $wpdb->prefix . "aspl_cf_form_data";
		$idd = $attr['text'];
		$form_data = $wpdb->get_results("SELECT * FROM $table_name where template_shortcode = '$idd' ");
			$string ="<div class='aspl-comtect-form-user'>" ;
			$string .="<form name='aspl_".$idd."' class='aspl_".$idd."' method='POST'>" ;
			$current_user = wp_get_current_user();
			$form_email = $current_user->user_email;

			$string .= "<input type='hidden' name='aspl-contect-hidden-field-user-email' class='aspl-contect-hidden-field-user-email' value='". $form_email ."'>";

			foreach ($form_data as $key => $value) {
					
					$string .= "<input type='hidden' name='aspl-contect-hidden-field-template-id' class='aspl-contect-hidden-field-template-id' value='". $value->template_id ."'>";
					$string .= "<input type='hidden' name='aspl-contect-hidden-field-form-name' class='aspl-contect-hidden-field-form-name' value='aspl_".$idd."'>";
					$string .= "<input type='hidden' class='ajaxurl' value='".admin_url('admin-ajax.php')."'>";

					$temp = $value->template_field_data;
					$fields_data = unserialize($temp);
				
					$string .= "<h2>".$value->template_title."</h2>";
					$string .= "<p>".$value->template_subtitle."</p>";

			 		foreach ($fields_data as $fields_data_value) {
			 			$array_data = array();
			 			$array_data[] = $fields_data_value;

						foreach ($array_data as $fields_value) {

							$field_type = $fields_value['form_field_type'];
							$field_attr_name = $fields_value['form_field_name'];
							$field_attr_id = $fields_value['form_field_attr_id'];
							$field_attr_class = $fields_value['form_field_class'];
							$field_attr_lable = $fields_value['form_field_lable'];
							@$field_option_type = $fields_value['option_fields'];
							if ( !empty($field_option_type)) {
								$options = $fields_value['option_fields'];

								$string .= aspl_cf_fields_func( $field_type , $field_attr_name , $field_attr_id , $field_attr_class , $field_attr_lable , $options );

							}else{
								
								$string .= aspl_cf_fields_func( $field_type , $field_attr_name , $field_attr_id , $field_attr_class , $field_attr_lable , $options = '' );

							}

						
						}

			 		}

			}
			$string .="</form>";
			$string .="</div>";
		return $string;

	} 
	add_shortcode( 'aspl-contact-form', 'aspl_cf_footag_func' );

/* End Create a ShortCode */

/* Fields Fuction */

	function aspl_cf_fields_func($type , $name , $attr_id , $attr_class , $attr_label , $option){

		$string = "";		

		if ($type == 'email') {

			$string .= "<div class='aspl-contect-fields-user'><label>".$attr_label."</label><input type='email' name='".$name."' id='".$attr_id."' class='".$attr_class."'></div>";
		
		}

		if ($type == 'text') {
			
			$string .="<div class='aspl-contect-fields-user'><label>".$attr_label."</label><input type='text' name='".$name."' id='".$attr_id."' class='".$attr_class."'></div>";	

		}

		if ($type == 'number') {

			$string .="<div class='aspl-contect-fields-user'><label>".$attr_label."</label><input type='number' name='".$name."' id='".$attr_id."' class='".$attr_class."'></div>";	

		}

		if ($type == 'password') {

			$string .="<div class='aspl-contect-fields-user'><label>".$attr_label."</label><input type='password' name='".$name."' id='".$attr_id."' class='".$attr_class."'></div>";	

		}

		if ($type == 'submit') {
			
			// $string .="<div class='aspl-contect-fields-user'><input type='submit' name='".$name."' id='".$attr_id."' class='aspl_email_btn ".$attr_class."' value='".$attr_label."'></div>";
			$string .="<div class='aspl-contect-fields-user'><span id='".$attr_id."' class='aspl_email_btn ".$attr_class."' >".$attr_label."</span></div>";	

		}

		if ($type == 'reset') {
			
			$string .="<div class='aspl-contect-fields-user'><input type='Reset' name='".$name."' id='".$attr_id."' class='".$attr_class."' value='".$attr_label."'></div>";	

		}

		if ($type == 'textarea') {

			$string .="<div class='aspl-contect-fields-user'><label>".$attr_label."</label><textarea name='".$name."' id='".$attr_id."' class='".$attr_class."'></textarea></div>";	

		}

		if ($type == 'date') {
	
			$string .= "<div class='aspl-contect-fields-user'><label>".$attr_label."</label><input type='date' name='".$name."' id='".$attr_id."'  class='".$attr_class."' ></div>";

		}

		if ($type == 'select') {
			if ($option == '') {
				
			}else{
				
				$string .= "<div class='aspl-contect-fields-user aspl-cf-fields-select-option'><label>".$attr_label."</label>";
				$string .= "<select name='".$name."' class='".$attr_class."' id='".$attr_id."'>";
                    $explode_data = explode("|",$option);
                    foreach ($explode_data as $key => $value) {
						$string .= "<option value='".trim($value)."'>".$value."</option>";
                    }
				$string .= "</select> </div>";

			}

		}

		return $string;
	}

/* End Fields Function */	


/**/

add_action('wp_ajax_aspl_cf_fuction_respons_sen_btn', 'aspl_cf_fuction_respons_sen_btn');
add_action('wp_ajax_nopriv_aspl_cf_fuction_respons_sen_btn', 'aspl_cf_fuction_respons_sen_btn');
function aspl_cf_fuction_respons_sen_btn(){

	$from = sanitize_text_field($_POST['from_email']);
	$template_id = sanitize_text_field($_POST['template_id']);
	$template_form_name = sanitize_text_field($_POST['template_form_name']).'<br>';
	$fields = $_POST['field_data_value'];



// aspl-contect-hidden-field-user-email	 aspl-contect-hidden-field-template-id	aspl-contect-hidden-field-form-name
	// var_dump($fields);
	
	global $wpdb;

	$table_name = $wpdb->prefix . "aspl_cf_form_data";
	$form_data = $wpdb->get_results("SELECT * FROM $table_name where template_id = '$template_id' ");
	foreach ($form_data as $key => $form_data_value) {
		$to = $form_data_value->template_email_to;
		$msg = $form_data_value->template_email_msg;

	}

	$subject = 'Apple Computer';
	$message = '';
	$message .= $msg.'<br>';
	$message .= '------<br>';
	$message .= '<table>';

		$message .= '<tr>';
			$message .= '<th>Fields Name</th>';
			$message .= '<th>Fields Value</th>';
		$message .= '</tr>';

	foreach ($fields as $key => $value) {
		if ( ($key == 'aspl-contect-hidden-field-user-email' ) || ($key == 'aspl-contect-hidden-field-template-id' ) || ($key == 'aspl-contect-hidden-field-form-name' ) ) {
			# code...
		}else{

			$message .= '<tr>';
				$message .= '<td>';
					$message .= $key;
				$message .= '</td>';
				$message .= '<td>';
					$message .= $value;
				$message .= '</td>';
			$message .= '</tr>';

		}
	}
	$message .= '</table>';

	$headers = '';	
	$headers .= 'From: '.$from.';' . "\r\n";	

	wp_mail( $to, $subject, $message , $headers);
	die();

}
/**/

