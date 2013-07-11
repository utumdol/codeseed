<?php
class Errors {

	public function __construct() {
		$this->messages = array();
	}

	public function add($message) {
		$this->messages[] = $message;
	}

	public function get_messages($glue = "\n") {
		return implode($glue, $this->messages);
	}
}

