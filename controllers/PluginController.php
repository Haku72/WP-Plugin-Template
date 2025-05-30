<?php

namespace controllers;

class PluginController
{

    static function init()
    {
        Settings::init_settings();
    }

    static function actionLinksFilter($actions) {
        $settings_link = 
        '<a
            href="' . Settings::get_page_url() . '">Settings
        </a>';

        return array_merge([$settings_link], $actions);
    }
    
    static function on_activate() {}

    static function on_deactivate() {}

    static function on_uninstall() {}
}
