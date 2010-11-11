<?php
class Session {

	public function save($key, $value) {
		$_SESSION[$key] = $value;
	}

	public function find($key) {
		return $_SESSION[$key];
	}

	public function update($key, $value) {
		$this->save($key, $value);
	}

	public function delete($key) {
		unset($_SESSION[$key]);
	}

	public function is_exist($key) {
		return array_key_exists($key, $_SESSION);
	}
}

