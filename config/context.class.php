<?php
/**
 * User Context
 * @author utumdol
 */
class Context {
	public $db;
	public $session;
	public $flash;
	public $log;

	private function __construct() {
		Config::init();
		$this->include_library();
		$this->db = $this->init_db();
		$this->session = $this->init_session();
		$this->flash = $this->init_flash();
		$this->log = Log::get_instance();
	}

	// singleton implementation
	private static $instance;
	public static function get_instance() {
		if (empty(self::$instance)) {
			self::$instance = new Context();
		}
		return self::$instance;
	}
	// the alias of get_instance
	public static function one() {
		return self::get_instance();
	}
	// just init context
	public static function init() {
		self::get_instance();
	}

	/**
	 * alias of $_GET[arg1][arg2][arg3][...]
	 */
	public static function _get(/* arg1, arg2, arg3, ... */) {
		return get_array_value($_GET, parse_array_args(func_get_args()));
	}

	/**
	 * alias of $_POST[arg1][arg2][arg3][...]
	 */
	public static function _post(/* arg1, arg2, arg3, ... */) {
		return get_array_value($_POST, parse_array_args(func_get_args()));
	}

	/**
	 * alias of $_FILES[arg1][arg2][arg3][...]
	 */
	public static function _files(/* arg1, arg2, arg3, ... */) {
		return get_array_value($_FILES, parse_array_args(func_get_args()));
	}

	/**
	 * alias of $_SERVER[arg1][arg2][arg3][...]
	 */
	public static function _server(/* arg1, arg2, arg3, ... */) {
		return get_array_value($_SERVER, parse_array_args(func_get_args()));
	}

	// include system and application library
	private function include_library() {
		require_once(Config::one()->sys_functions . '/system.php');
		require_once_dir(Config::one()->sys_functions);
		require_once_dir(Config::one()->sys_classes);

		require_once_dir(Config::one()->conf_dir);
		if (file_exists(Config::one()->ctrl_dir . '/application_controller.class.php')) {
			require_once(Config::one()->ctrl_dir . '/application_controller.class.php');
		}
		if (file_exists(Config::one()->help_dir . '/application.php')) {
			require_once(Config::one()->help_dir . '/application.php');
		}
		if (file_exists(Config::one()->model_dir)) {
			require_once_dir(Config::one()->model_dir);
		}
	}

	private function init_db() {
		$dbms = Config::one()->db;
		$db = new $dbms(Config::one()->db_host, Config::one()->db_user, Config::one()->db_password, Config::one()->db_name);
		return $db;
	}

	private function init_session() {
		if (Config::one()->use_db_session) {
			session_set_save_handler(
					array('DbSession', 'open'), array('DbSession', 'close'),
					array('DbSession', 'read'), array('DbSession', 'write'),
					array('DbSession', 'destroy'), array('DbSession', 'clean'));
		}
		return new Session();
	}

	private function init_flash() {
		return new Flash($this->session);
	}
}

