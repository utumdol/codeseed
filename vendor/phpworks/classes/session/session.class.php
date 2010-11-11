<?php
class Session {
	public $session;

	public function Session() {
		$this->session = $_SESSION;
	}

	public function save($key, $value) {
		$this->session[$key] = $value;
	}

	public function find($key) {
		return $this->session[$key];
	}

	public function update($key, $value) {
		$this->save($key, $value);
	}

	public function delete($key) {
		$this->session[$key] = null;
	}
}

