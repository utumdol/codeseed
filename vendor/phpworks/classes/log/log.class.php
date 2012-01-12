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
	public static function get_instance($log_level, $filename) {
		if (empty(Log::$instance)) {
			Log::$instance = new Log($log_level, $filename);
		}
		return Log::$instance;
	}

	public static function one() {
		return Log::$instance;
	}

	public function trace($message) {
		$this->log('trace', $message);
	}

	public function debug($message) {
		$this->log('debug', $message);
	}

	public function info($message) {
		$this->log('info', $message);
	}

	public function warn($message) {
		$this->log('warn', $message);
	}

	public function error($message) {
		$this->log('error', $message);
	}

	public function fatal($message) {
		$this->log('fatal', $message);
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

