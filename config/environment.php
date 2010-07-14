<?php
define('ROOT_DIR', realpath(dirname(__FILE__) . '/..'));
define('ROOT_FILE', basename($_SERVER['SCRIPT_FILENAME']));

define('SYS_DIR', ROOT_DIR . '/vendor/phpworks');
define('SYS_CLASSES', SYS_DIR . '/classes');
define('SYS_FUNCTIONS', SYS_DIR . '/functions');

define('APP_DIR', ROOT_DIR . '/app');
define('CONF_DIR', ROOT_DIR . '/config');
define('CNTR_DIR', APP_DIR . '/controllers');
define('MODEL_DIR', APP_DIR . '/models');
define('VIEW_DIR', APP_DIR . '/views');
define('HELP_DIR', APP_DIR . '/helpers');
define('MIGR_DIR', ROOT_DIR . '/db/migrate');

define('BR', '<br/>');
define('NL', "\n");
define('BN', "<br/>\n");

// include system helpers
require_once(SYS_FUNCTIONS . '/system.php');

// include all system helpers
require_once_dir(SYS_FUNCTIONS);
// include required system classes
require_once_dir(SYS_CLASSES);

// include all application configs
require_once_dir(CONF_DIR);
// include default application helper
require_once(HELP_DIR . '/application.php');
// include all application models
require_once_dir(MODEL_DIR);

$DATABASE = get_database();

