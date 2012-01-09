<?php
/**
 * User Context
 * @author utumdol
 */
class Context {
	public $db;
	public $get;
	public $post;
	public $server;
	public $params;
	public $session;
	public $flash;
	public $log;

	private function __construct() {
		$this->get = $_GET;
		$this->post = $_POST;
		$this->files = $_FILES;
		$this->server = $_SERVER;
		$this->params = array_merge($this->get, $this->post);

		Config::init();
		$this->include_library();
		$this->db = $this->init_db();
		$this->session = $this->init_session();
		$this->flash = $this->init_flash();
		$this->log = $this->init_log();
	}

	// singleton implementation
	private static $instance;
	public static function get_instance() {
		if (empty(Context::$instance)) {
			Context::$instance = new Context();
		}
		return Context::$instance;
	}
	// the alias of get_instance
	public static function one() {
		return Context::get_instance();
	}
	// just init context
	public static function init() {
		Context::get_instance();
	}

	// get from $_GET
	public static function get($key = '') {
		if (in_array($key, $_GET)) {
			return $_GET[$key];
		}
		return null;
	}

	// get from $_POST
	public static function post($key = '') {
		if (in_array($key, $_POST)) {
			return $_POST[$key];
		}
		return null;
	}

	// get from $_FILES
	public static function files($key = '') {
		if (in_array($key, $_FILES)) {
			return $_FILES[$key];
		}
		return null;
	}

	// get from $_SERVER
	public static function server($key = '') {
		if (in_array($key, $_SERVER)) {
			return $_SERVER[$key];
		}
		return null;
	}

	// get from $_GET or $_POST
	public static function param($key = '') {
		$result = Context::get($key);
		if (!is_null($result)) {
			return $result;
		}
		return Context::post($key);
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

	private function init_log() {
		$filename = Config::one()->log_dir . '/' . Config::one()->mode . '.log';
		return Log::get_instance(Config::one()->log_level, $filename);
	}
}

