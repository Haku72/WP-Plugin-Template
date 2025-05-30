<?php

$error_log_path = plugin_dir_path(__FILE__).'error.log';

if(!defined('{PREFIX}_PLUGIN_PATH')) {
    define('{PREFIX}_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

if (!defined('{PREFIX}_PLUGIN_URL')) {
    define('{PREFIX}_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (!defined('{PREFIX}_CACHE_PATH')) {
    define('{PREFIX}_CACHE_PATH', {PREFIX}_PLUGIN_PATH . 'public/cache');
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
