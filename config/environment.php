<?php
define('ROOT_DIR', dirname(__FILE__) . '/..');
define('ROOT_FILE', basename($_SERVER['SCRIPT_FILENAME']));

define('SYS_DIR', ROOT_DIR . '/vendor/phpworks');
define('SYS_CNTR_DIR', SYS_DIR . '/controllers');
define('SYS_MODEL_DIR', SYS_DIR . '/models');
define('SYS_VIEW_DIR', SYS_DIR . '/views');
define('SYS_HELP_DIR', SYS_DIR . '/helpers');
define('SYS_MIGR_DIR', SYS_DIR . '/db/migrate');

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

// include genesis system helpers
require_once(SYS_HELP_DIR . '/system.php');

// include all system helpers
require_once_dir(SYS_HELP_DIR);
// include required system classes
require_once_dir(SYS_CNTR_DIR);
require_once_dir(SYS_MODEL_DIR);
require_once_dir(SYS_MIGR_DIR);

// include all application configs
require_once_dir(CONF_DIR);
// include all application helpers
require_once_dir(HELP_DIR);
// include all application models
require_once_dir(MODEL_DIR);

// include db driver
require_once(SYS_DIR . '/db/' . DBMS . '.class.php');

$DATABASE = get_database();
?>
