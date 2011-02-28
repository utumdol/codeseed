<?php
/**
 * User Context
 * @author utumdol
 */
class Context {
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


	private function include_library() {
		require_once(Config::get()->sys_functions . '/system.php');

		// include all system helpers
		require_once_dir(Config::get()->sys_functions);
		// include required system classes
		require_once_dir(Config::get()->sys_classes);

		// include all application configs
		require_once_dir(Config::get()->conf_dir);
		// include default application helper
		require_once(Config::get()->help_dir . '/application.php');
		// include all application models
		require_once_dir(Config::get()->model_dir);
	}
}

