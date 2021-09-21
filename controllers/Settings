<?php

abstract class PLUGIN_OPTIONS {
    const OPTION_1 = 'option-1';
}

class Settings
{
    private static $options_prefix = '{PREFIX}';
    private static $nonce_key = 'admin-ajax-nonce';

    static function init_settings()
    {

//
//
//        add_settings_section('general-options', 'Import Options', function () {
//        }, {PREFIX}_MENU_SLUG);
//
//        self::add_setting(
//            'poststatus',
//            'Immediately Publish',
//            {PREFIX}_PLUGIN_PATH . '/views/partials/option-poststatus.php',
//            'general-options'
//        );
    }

    static function init_menu()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        add_submenu_page(
            'tools.php',
            '{Plugin Name}',
            '{Plugin Menu Title}',
            'manage_options',
            {PREFIX}_MENU_SLUG,
            function () {
                require({PREFIX}_PLUGIN_PATH . '/views/plugin-menu.php');
            }
        );
    }

    static function enqueue()
    {
        //standard WP enqueue functions go here
    }

    static function error_notice($msg = '')
    {
        include({PREFIX}_PLUGIN_PATH . '/views/error-notice.php');
    }

    static function get_page_url()
    {
        return admin_url('tools.php?page=' . {PREFIX}_MENU_SLUG);
    }

    static function get_nonce_key()
    {
        return self::$nonce_key;
    }

    /**
     * Enter custom validation logic here
     *
     * @param $input
     * @return bool
     */
    static function validate($input) {
        return true;
    }

    /**
     * Add a setting and HTML view template for setting into a given Setting section
     *
     * @param $id String Setting ID
     * @param $title String Setting title
     * @param $view_url String template file path
     * @param $section String Setting Section label
     */
    private static function add_setting($setting_name, $title, $view_url, $section)
    {
        register_setting({PREFIX}_PLUGIN_SETTINGS, $setting_name, [
            'sanitize_callback' => [__CLASS__, 'validate']
        ]);
        
        add_settings_field($setting_name, $title, static function () use ($setting_name, $view_url) {
            $option_name = self::$options_prefix . $setting_name;
            $value = self::get_setting(option_name); //pass these fields into the include template
            $name = $option_name;

            include($view_url);

        }, {PREFIX}_MENU_SLUG, $section);
    }

    /**
     * Pass in a callback function for html output instead of template path.
     * I wish function overloading was possible.
     *
     * @param $id String Setting ID
     * @param $title String Setting title
     * @param $foo * Callback function
     * @param $section String Setting Section label
     */
    private static function add_setting_cb($setting_name, $title, $foo, $section)
    {
        register_setting({PREFIX}_PLUGIN_SETTINGS, $setting_name, [
            'sanitize_callback' => [__CLASS__, 'validate']
        ]);

        add_settings_field($setting_name, $title, $foo, {PREFIX}_MENU_SLUG, $section);
    }

    public static function get_setting($setting_name) {
        $option_name = self::$options_prefix . $setting_name;

        return get_option($option_name);
    }
}
