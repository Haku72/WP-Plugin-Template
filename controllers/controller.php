<?php

require MUB_PLUGIN_PATH . '/controllers/Settings.php';

class CalendarIntegration {
    private static $log_path = MUB_PLUGIN_PATH . 'error.log';

    static function init() {
        Settings::init_menu();
    }
}
