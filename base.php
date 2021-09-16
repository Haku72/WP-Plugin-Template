<?php
/**
 * Plugin Name: Plugin Template
 * Description: base template for a WP plugin
 * Version: 0.1
 * Author: Person
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


$prefix = 'MUB_CAL';
$error_log_path = plugin_dir_path(__FILE__).'error.log';

if(!defined('MUB_PLUGIN_PATH')) {
    define('MUB_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

/**
 * Settings group key
 */
if(!defined('MUB_SETTINGS_GROUP')) {
    define('MUB_SETTINGS_GROUP', 'mubcal');
}

if(!defined('MUB_MENU_SLUG')) {
    define('MUB_MENU_SLUG', 'mubcal');
}


/**
* Include & activate plugin class here
*/
//include( MUB_PLUGIN_PATH . '/controllers/CalendarIntegration.php' );
//CalendarIntegration::init();

register_activation_hook(__FILE__, function() {});
register_deactivation_hook(__FILE__, function() {});

function ALSWH_IMPORT_DeleteSettings(){
    delete_option(Settings::get_options_name());
}
register_uninstall_hook(__FILE__, 'MUB_CAL_DeleteSettings');
