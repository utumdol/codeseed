<?php
/**
 * PHPWorks Configuration
 * @author utumdol
 */
class Config {

	// init environment
	public $hostnames = array(
		'dev' => array('phpworks.locahost', 'localhost'),
		'test' => array('phpworks.testhost'),
		'real' => array('phpworks.realhost')
	);

	// for session cryption. you can change it.
	public $crypt_key = 'a2c$%^*()';

	// default routing. you can change it.
	public $default_controller = 'blog';
	public $default_action = 'index';

	// default model repository. you can change it.
	private function __construct() {
		$this->set_mode();
		switch($this->mode) {
			case 'dev':
				$this->db = 'MySql';
				$this->db_user = 'phpworks';
				$this->db_password = '';
				$this->db_name = 'phpworks';
				$this->db_host = 'localhost';
				$this->db_port = '3306';
				$this->use_db_session = true;
				$this->log_level = 'debug';
				break;
			case 'test':
				$this->db = 'MySql';
				$this->db_user = 'phpworks';
				$this->db_password = '';
				$this->db_name = 'phpworks';
				$this->db_host = 'localhost';
				$this->db_port = '3306';
				$this->use_db_session = true;
				$this->log_level = 'debug';
				break;
			case 'real';
				$this->db = 'MySql';
				$this->db_user = 'phpworks';
				$this->db_password = '';
				$this->db_name = 'phpworks';
				$this->db_host = 'localhost';
				$this->db_port = '3306';
				$this->use_db_session = true;
				$this->log_level = 'info';
				break;
		}
		$this->set_system_directory();
		$this->set_app_directory();
		$this->set_base_define();
	}

	// local settings
	//public $admin_name = '';
	//public $admin_email = '';

	///////////////////////////////////////////////////////////////////////////
	// You don't need to change the below setttings
	///////////////////////////////////////////////////////////////////////////

	// singleton implementation
	private static $instance;
	public static function get_instance() {
		if (empty(Config::$instance)) {
			Config::$instance = new Config();
		}
		return Config::$instance;
	}
	// the alias of get_instance
	public static function get() {
		return Config::get_instance();
	}
	// just init Config
	public static function init() {
		Config::get_instance();
	}

	private function set_system_directory() {
		$this->root_dir = realpath(dirname(__FILE__) . '/..');
		$this->root_file = basename($_SERVER['SCRIPT_FILENAME']);
		$this->sys_dir = $this->root_dir . '/vendor/phpworks';
		$this->sys_classes = $this->sys_dir . '/classes';
		$this->sys_functions = $this->sys_dir . '/functions';
		$this->log_dir = $this->root_dir . '/log';
	}

	private function set_app_directory() {
		$this->app_dir = $this->root_dir . '/app';
		$this->conf_dir = $this->root_dir . '/config';
		$this->ctrl_dir = $this->app_dir . '/controller';
		$this->model_dir = $this->app_dir . '/model';
		$this->view_dir = $this->app_dir . '/view';
		$this->help_dir = $this->app_dir . '/helper';
		$this->migr_dir = $this->app_dir . '/migrate';
	}

	private function set_base_define() {
		define('BR', '<br/>');
		define('NL', "\n");
		define('BN', BR . NL);
	}

	private function set_mode() {
		$hostname = php_uname('n');
		foreach($this->hostnames as $mode => $hostnames) {
			if (in_array($hostname, $hostnames)) {
				$this->mode = $mode;
				break;
			}
		}
	}

	// default model repository.
	public $db;
	public $db_user;
	public $db_password;
	public $db_name;
	public $db_host; // not necessary
	public $db_port; // not necessary

	// system directory
	public $root_dir;
	public $root_file;
	private $sys_dir;
	public $sys_classes;
	public $sys_functions;

	// app directory
	public $app_dir;
	public $conf_dir;
	public $ctrl_dir;
	public $model_dir;
	public $view_dir;
	public $help_dir;
	public $migr_dir;

	// etc
	public $use_db_session;
	public $log_dir;
	public $log_level; // all, trace, debug, info, warn, error, fatal, off
	public $mode = 'dev'; // dev, test, real
}

