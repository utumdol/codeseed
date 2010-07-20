<?php
class Flash {
	var $flashes;

	public function load() {
		if (isset($_SESSION['flash'])) {
			$this->flashes = unserialize($_SESSION['flash']);
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
		$_SESSION['flash'] = serialize($this->flashes);
	}
}

