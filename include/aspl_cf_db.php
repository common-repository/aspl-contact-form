<?php 


if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}
	
global $wpdb;
$table_name = $wpdb->prefix . "aspl_cf_form_data";
$charset_collate = $wpdb->get_charset_collate();

if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {

    $sql = "CREATE TABLE $table_name (
            `template_id` mediumint(9) NOT NULL AUTO_INCREMENT,
            `template_title` text(200) NOT NULL,
            `template_subtitle` text,
            `template_shortcode` text NOT NULL,
            `template_date` text NOT NULL,
            `template_field_data` text NOT NULL,
            `template_email_to` text(200),
            `template_email_subject` text(200),
            `template_email_msg` text(1000),
            PRIMARY KEY  (template_id)
    )$charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    // add_option( my_db_version', $my_products_db_version );
}



 ?>