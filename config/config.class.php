<?php
/**
 * PHPWorks Configuration
 * @author utumdol
 */
class Config {

	// init environment
	public $mode = 'dev'; // dev, test, real
	public static $is_debug = true;

	// for session cryption. you can change it.
	public $crypt_key = 'a2c$%^*()';

	// default routing. you can change it.
	public $default_controller = 'blog';
	public $default_action = 'index';

	// default model repository. you can change it.
	private function __construct() {
		switch($this->mode) {
			case 'dev':
				$this->dao = 'MySql';
				$this->dao_id = 'root';
				$this->dao_password = '';
				$this->dao_db = 'phpworks2';
				$this->dao_host = 'localhost';
				$this->dao_port = '3306';
				break;
			case 'test':
				$this->dao = 'MySql';
				$this->dao_id = 'root';
				$this->dao_password = '';
				$this->dao_db = 'phpworks';
				$this->dao_host = 'localhost';
				$this->dao_port = '3306';
				break;
			case 'real';
				$this->dao = 'MySql';
				$this->dao_id = 'root';
				$this->dao_password = '';
				$this->dao_db = 'phpworks';
				$this->dao_host = 'localhost';
				$this->dao_port = '3306';
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
	public $dao;
	public $dao_id;
	public $dao_password;
	public $dao_db;
	public $dao_host; // not necessary
	public $dao_port; // not necessary

	// system directory
	private $root_dir;
	private $root_file;
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

// for debugging
if (Config::$is_debug) {
	$config = Config::get_instance();
	print_r($config);
}

