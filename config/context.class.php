<?php
/**
 * User Context
 * @author utumdol
 */
class Context {
	private $db;
	private $session;
	private $flash;
	private $log;

	private function __construct() {
		Config::init();
		$this->include_library();
		$this->db = $this->init_db();
		$this->session = $this->init_session();
		$this->flash = $this->init_flash();
		$this->log = $this->init_log();
		$this->init_cache();
	}

	// singleton implementation
	private static $instance;
	public static function get_instance() {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	// attribute accessor
	public static function get($prop) {
		return self::get_instance()->$prop;
	}

	// just init context
	public static function init() {
		self::get_instance();
	}

	// include system and application default library
	private function include_library() {
		require_once(Config::get('plugin_functions') . '/system.php');
		require_once_dir(Config::get('plugin_functions'));
		require_once_dir(Config::get('plugin_classes'));

		require_once_dir(Config::get('conf_dir'));
		if (file_exists(Config::get('ctrl_dir') . '/application_controller.class.php')) {
			require_once(Config::get('ctrl_dir') . '/application_controller.class.php');
		}
		if (file_exists(Config::get('help_dir') . '/application.php')) {
			require_once(Config::get('help_dir') . '/application.php');
		}
	}

	private function init_db() {
		$dbms = Config::get('db');
		$db = new $dbms(Config::get('db_host'), Config::get('db_user'), Config::get('db_password'), Config::get('db_name'));
		return $db;
	}

	private function init_session() {
		if (Config::get('use_db_session')) {
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
		$filename = Config::get('log_dir') . '/application.log';
		return Log::get_instance(Config::get('log_level'), $filename);
	}

	private function init_cache() {
		if (!file_exists(Config::get('tmp_dir') . '/restart.txt')) {
			return;
		}

		if (apc_clear_cache('user')) {
			Log::info("apc_clear_cache success");
		} else {
			Log::info("apc_clear_cache success fail");
		}

		unlink(Config::get('tmp_dir') . '/restart.txt');
	}
}

