<?php
class Log {

	private $log_levels = array(
		'all' => 1,
		'trace' => 2,
		'debug' => 3,
		'info' => 4,
		'warn' => 5,
		'error' => 6,
		'fatal' => 7,
		'off' => 8
	);
	private $log_level;
	private $filename;

	private function __construct($log_level, $filename) {
		$this->log_level = $log_level;
		$this->filename = $filename;
	}

	// singleton implementation
	private static $instance;
	public static function get_instance() {
		if (empty(self::$instance)) {
			$filename = Config::one()->log_dir . '/' . Config::one()->mode . '.log';
			self::$instance = new Log(Config::one()->log_level, $filename);
		}
		return self::$instance;
	}

	public static function trace($message) {
		self::get_instance()->log('trace', $message);
	}

	public static function debug($message) {
		self::get_instance()->log('debug', $message);
	}

	public static function info($message) {
		self::get_instance()->log('info', $message);
	}

	public static function warn($message) {
		self::get_instance()->log('warn', $message);
	}

	public static function error($message) {
		self::get_instance()->log('error', $message);
	}

	public static function fatal($message) {
		self::get_instance()->log('fatal', $message);
	}

	private function log($level, $message) {
		if ($this->log_levels[$level] < $this->log_levels[$this->log_level]) {
			return;
		}
		$message = date('Y-m-d H:i:s') . ' [' . strtoupper($level) . '] ' . $message . "\n";
		$this->touch();
		$f = fopen($this->filename, 'a');
		fwrite($f, $message, strlen($message)); 
		fclose($f);
	}

	private function touch() {
		if (file_exists($this->filename)) {
			return;
		}
		touch($this->filename);
		chmod($this->filename, 0666);
	}
}

