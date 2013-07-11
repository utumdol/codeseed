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
	public static function get_instance($log_level = '', $filename = '') {
		if (empty(self::$instance)) {
			self::$instance = new Log($log_level, $filename);
		}
		return self::$instance;
	}

	public static function trace($message) {
		self::$instance->log('trace', $message);
	}

	public static function debug($message) {
		self::$instance->log('debug', $message);
	}

	public static function info($message) {
		self::$instance->log('info', $message);
	}

	public static function warn($message) {
		self::$instance->log('warn', $message);
	}

	public static function error($message) {
		self::$instance->log('error', $message);
	}

	public static function fatal($message) {
		self::$instance->log('fatal', $message);
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

