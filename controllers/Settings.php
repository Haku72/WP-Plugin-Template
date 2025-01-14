<?php

abstract class PLUGIN_SETTING_SECTIONS
{
    const SECTION_1 = 'section-1';
}
abstract class PLUGIN_SETTINGS
{
    const OPTION_1 = 'option-1';
}
class Settings
{
    private static $options_prefix = '{PREFIX}';
    private static $nonce_key = 'admin-ajax-nonce';

    static function init_settings()
    {
        add_action('admin_init', static function() {
            self::add_setting_section(PLUGIN_SETTING_SECTIONS::SECTION_1, 'General Options', 'general-options');
            self::add_setting(
                PLUGIN_SETTING_SECTIONS::SECTION_1,
                PLUGIN_SETTINGS::SETTING_1,
                "Setting 1",
                'general-options'
            );
        });
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
            '{PREFIX}_MENU_SLUG',
            function () {
                require('{PREFIX}_PLUGIN_PATH' . '/views/plugin-menu.php');
            }
        );
    }

    static function enqueue()
    {
        //standard WP enqueue functions go here
    }

    static function error_notice($msg = '')
    {
        include('{PREFIX}_PLUGIN_PATH' . '/views/error-notice.php');
    }

    static function get_page_url()
    {
        return admin_url('tools.php?page=' . '{PREFIX}_MENU_SLUG');
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

    public static function get_setting($setting_name) {
        $option_name = self::$options_prefix . $setting_name;

        return get_option($option_name);
    }

    
    /**
     * Adds a settings section to the given page.
     * 
     * Register a settings section with WordPress. It calls the WordPress function `add_settings_section` with the provided parameters.
     * 
     * @param string $id Slug-name to identify the section. Used in the 'id' attribute of tags.
     * @param string $title Formatted title of the section. Shown as the heading for the section.
     * @param callable $cb Function that echos out any content at the top of the section (between heading and fields).
     * @param string $page The slug-name of the settings page on which to show the section.
     * @param array $args Additional arguments to pass to the callback function.
     * 
     * @see https://developer.wordpress.org/reference/functions/add_settings_section/
     */
    private static function add_setting_section(string $id, string $title, string $page, callable $cb = null, $args = []) {
        add_settings_section($id, $title, $cb, $page, $args);
    }

    /**
     * Registers a setting and adds a settings field to the specified section.
     * 
     * This method registers a setting with WordPress and adds a settings field to the specified section.
     * The settings field is populated with a template from the provided URL.
     * 
     * @param string $section_slug The slug of the section where the setting will be added.
     * @param string $setting_id The ID of the setting.
     * @param string $title Setting label displayed in the options form.
     * @param string $view_path The URL of the template file for the setting.
     */
    private static function add_setting($section_slug, $setting_id, $title, $view_url)
    {
        $option_name = self::$options_prefix . $setting_id;
        register_setting($section_slug, $setting_id, [
            'sanitize_callback' => [__CLASS__, 'validate']
        ]);

        add_settings_field($setting_id, $title, static function () use ($option_name, $view_path) {
            $value = self::get_setting($option_name); //pass these fields into the include template
            $name = $option_name;

            include($view_path);
        }, '{PREFIX}_MENU_SLUG', $section_slug);
    }

    /**
     * Same as above, except pass in a callback function for html output instead of template path.
     * I wish function overloading was possible.
     */
    private static function add_setting_cb($section_slug, $setting_id, $title, callable $foo)
    {
        register_setting(GFMONITOR_SETTINGS_GROUP, $setting_id, [
            'sanitize_callback' => [__CLASS__, 'validate']
        ]);

        add_settings_field($setting_id, $title, $foo, '{PREFIX}_MENU_SLUG', $section_slug);
    }
}
