<?php
class Generator {
	var $name = '';
	var $path = '';
	var $template = '';

	public function Generator($name) {
		$this->name = $name;
	}

	public function generate() {
		$this->validation();
		$this->generatePath();
		$this->generateFile();
	}

	public function validation() {
		if (file_exists($this->getPath() . '/' . $this->getFileName())) {
			throw new ValidationError($this->getPath() . '/' . $this->getFileName() . ' is already exists.');
		}
	}

	public function getPath() {
		return $this->path;
	}

	public function getFileName() {
		return $this->name;
	}

	public function getContents() {
		return $this->template;
	}

	public function generatePath() {
		if (is_dir($this->getPath())) {
			echonl('exist ' . $this->getPath());
		} else {
			echonl('generate ' . $this->getPath());
			mkdir($this->getPath(), 0755, true);
		}
	}

	public function generateFile() {
		$filename = $this->getFileName();
		$content = $this->getContents();
		echonl('generate ' . $this->getPath() . '/' . $filename);
		$f = fopen($this->getPath() . '/' . $filename, 'w');
		fwrite($f, $content, strlen($content)); 
		fclose($f);
	}
}

