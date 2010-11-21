<?php
class Flash {
	private $flashes;
	private $session;

	public function __construct($session) {
		$this->session = $session;
	}

	public function load() {
		if ($this->session->is_exist('flash')) {
			$this->flashes = unserialize($this->session->get('flash'));
		} else {
			$this->flashes = array();
		}
	}

	public function add($key, $value) {
		$this->flashes[] = new FlashElement($key, $value);
	}

	public function get($key) {
		foreach($this->flashes as $flash) {
			if ($flash->name == $key) {
				return $flash->value;
			}
		}
		return null;
	}

	public function clear() {
		$reserves = array();
		foreach($this->flashes as $flash) {
			$flash->life--;
			if ($flash->life >= 0) {
				$reserves[] = $flash;
			}
		}
		$this->flashes = $reserves;
	}

	public function save() {
		$this->session->save('flash', serialize($this->flashes));
	}
}

