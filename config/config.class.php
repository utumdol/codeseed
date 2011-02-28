<?php
/**
 * PHPWorks Configuration
 * @author utumdol
 */
class Config {

	// init environment
	public $mode = 'dev'; // dev, test, real
	public static $is_debug = false;

	// for session cryption. you can change it.
	public $crypt_key = 'a2c$%^*()';

	// default routing. you can change it.
	public $default_controller = 'blog';
	public $default_action = 'index';

	// default model repository. you can change it.
	private function __construct() {
		switch($this->mode) {
			case 'dev':
				$this->db = 'MySql';
				$this->db_user = 'root';
				$this->db_password = '';
				$this->db_name = 'phpworks';
				$this->db_host = 'localhost';
				$this->db_port = '3306';
				break;
			case 'test':
				$this->db = 'MySql';
				$this->db_user = 'root';
				$this->db_password = '';
				$this->db_name = 'phpworks';
				$this->db_host = 'localhost';
				$this->db_port = '3306';
				break;
			case 'real';
				$this->db = 'MySql';
				$this->db_user = 'root';
				$this->db_password = '';
				$this->db_name = 'phpworks';
				$this->db_host = 'localhost';
				$this->db_port = '3306';
				break;
		}

		$this->set_system_directory();
		$this->set_app_directory();
		$this->set_base_define();

	}

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
}

