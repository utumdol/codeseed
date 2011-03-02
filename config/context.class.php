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

	private function __construct() {
		$this->get = $_GET;
		$this->post = $_POST;
		$this->server = $_SERVER;
		$this->params = array_merge($this->get, $this->post);

		Config::init();
		$this->include_library();
		$this->db = $this->init_db();
		$this->session = $this->init_session();
		$this->flash = $this->init_flash();
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
	public static function get() {
		return Context::get_instance();
	}
	// just init context
	public static function init() {
		Context::get_instance();
	}
	
	// include system and application library
	private function include_library() {
		require_once(Config::get()->sys_functions . '/system.php');
		require_once_dir(Config::get()->sys_functions);
		require_once_dir(Config::get()->sys_classes);

		require_once_dir(Config::get()->conf_dir);
		require_once(Config::get()->help_dir . '/application.php');
		require_once_dir(Config::get()->model_dir);
	}

	private function init_db() {
		$dbms = Config::get()->db;
		$db = new $dbms(Config::get()->db_host, Config::get()->db_user, Config::get()->db_password, Config::get()->db_name);
		return $db;
	}

	private function init_session() {
		session_set_save_handler(
				array('DbSession', 'open'), array('DbSession', 'close'),
				array('DbSession', 'read'), array('DbSession', 'write'),
				array('DbSession', 'destroy'), array('DbSession', 'clean'));
		return new Session();
	}

	private function init_flash() {
		return new Flash($this->session);
	}
}

