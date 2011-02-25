<?php
// include system init 
require_once(dirname(__FILE__) . '/../../../../config/config.class.php');

/**
 * User Context
 * @author utumdol
 */
class Context {
	private $get;
	private $post;
	private $server;
	private $config;
	private $params;
	private $session;
	private $flash;

	private function __construct() {
		$this->get = $_GET;
		$this->post = $_POST;
		$this->server = $_SERVER;
		$this->config = Config::get();
		$this->params = array_merge($this->get, $this->post);

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

	// just init context
	public static function init() {
		Context::get_instance();
	}

	private function include_library() {
		require_once($this->config->sys_functions . '/system.php');

		// include all system helpers
		require_once_dir($this->config->sys_functions);
		// include required system classes
		require_once_dir($this->config->sys_classes);

		// include all application configs
		require_once_dir($this->config->conf_dir);
		// include default application helper
		require_once($this->config->help_dir . '/application.php');
		// include all application models
		require_once_dir($this->config->model_dir);
	}
}

// for debugging
if (Config::$is_debug) {
	$globals = Context::get_instance();
	print_r($globals);
}

