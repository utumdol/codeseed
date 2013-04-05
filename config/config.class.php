<?php
/**
 * PHPWorks Configuration
 * @author utumdol
 */
class Config {
	// init environment

	// for session cryption. you can change it.
	private $crypt_key = 'a2c$%^*()';

	// default routing. you can change it.
	private $default_controller = 'blog';
	private $default_action = 'index';

	// default model repository. you can change it.
	private function __construct() {
		$this->db = 'MySql';
		$this->db_user = 'codeseed';
		$this->db_password = '';
		$this->db_name = 'codeseed';
		$this->db_host = 'localhost';
		$this->db_port = '3306';
		$this->use_db_session = false;
		$this->log_level = 'debug';

		$this->set_system_directory();
		$this->set_app_directory();
		$this->set_base_define();
	}

	// local settings
	//private $admin_name = '';
	//private $admin_email = '';

	///////////////////////////////////////////////////////////////////////////
	// You don't need to change the below setttings
	///////////////////////////////////////////////////////////////////////////

	// singleton implementation
	private static $instance;
	public static function get_instance() {
		if (empty(self::$instance)) {
			self::$instance = new Config();
		}
		return self::$instance;
	}

	// attribute accessor
	public static function get($prop) {
		return self::get_instance()->$prop;
	}

	// just init Config
	public static function init() {
		self::get_instance();
	}

	private function set_system_directory() {
		$this->root_dir = realpath(dirname(__FILE__) . '/..');
		$this->root_file = basename($_SERVER['SCRIPT_FILENAME']);
		$this->vendor_dir = $this->root_dir . '/vendor';
		$this->sys_dir = $this->vendor_dir . '/codeseed';
		$this->sys_classes = $this->sys_dir . '/classes';
		$this->sys_functions = $this->sys_dir . '/functions';

		$this->log_dir = $this->root_dir . '/log';
		$this->public_dir = $this->root_dir . '/public';
		$this->upload_dir = $this->root_dir . '/upload';
		$this->tmp_dir =  $this->root_dir . '/tmp';
	}

	private function set_app_directory() {
		$this->app_dir = $this->root_dir . '/app';
		$this->conf_dir = $this->root_dir . '/config';
		$this->ctrl_dir = $this->app_dir . '/controller';
		$this->model_dir = $this->app_dir . '/model';
		$this->view_dir = $this->app_dir . '/view';
		$this->layout_dir = $this->view_dir . '/layout';
		$this->help_dir = $this->app_dir . '/helper';
		$this->migr_dir = $this->app_dir . '/migrate';
	}

	private function set_base_define() {
		define('BR', '<br/>');
		define('CR', "\r");
		define('NL', "\n");
		define('BN', BR . NL);
		define('CL', CR . NL);
	}

	// default model repository.
	private $db;
	private $db_user;
	private $db_password;
	private $db_name;
	private $db_host; // not necessary
	private $db_port; // not necessary

	// system directory
	private $root_dir;
	private $root_file;
	private $sys_dir;
	private $sys_classes;
	private $sys_functions;

	// app directory
	private $app_dir;
	private $conf_dir;
	private $ctrl_dir;
	private $model_dir;
	private $view_dir;
	private $layout_dir;
	private $help_dir;
	private $migr_dir;

	// etc
	private $use_db_session;
	private $log_dir;
	private $log_level; // all, trace, debug, info, warn, error, fatal, off
	private $public_dir;
	private $upload_dir;
	private $tmp_dir;
}

