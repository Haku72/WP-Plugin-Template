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


$prefix = '{plugin prefix}';
$error_log_path = plugin_dir_path(__FILE__).'error.log';

if(!defined('{PREFIX}_PLUGIN_PATH')) {
    define('{PREFIX}_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

/**
 * Settings group key
 */
if(!defined('{PREFIX}_SETTINGS_GROUP')) {
    define('{PREFIX}_SETTINGS_GROUP', '{value}');
}

if(!defined('{PREFIX}_MENU_SLUG')) {
    define('{PREFIX}_MENU_SLUG', '{value}');
}


/**
* Include & activate plugin class here
*/
//include( MUB_PLUGIN_PATH . '/controllers/CalendarIntegration.php' );
//CalendarIntegration::init();

/**
* Function hooks for plugin events
*/
register_activation_hook(__FILE__, static function () {});
register_deactivation_hook(__FILE__, static function () {});
register_uninstall_hook(__FILE__, static function () {});
