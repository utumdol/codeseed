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
		return true;
	}

	public function getFileName() {
		return $this->name;
	}

	public function getContents() {
		return $this->template;
	}

	public function generatePath() {
		if (is_dir($this->path)) {
			echonl('exist ' . $this->path);
		} else {
			echonl('generate ' . $this->path);
			mkdir($this->path, 0755, true);
		}
	}

	public function generateFile() {
		$filename = $this->getFileName();
		$content = $this->getContents();
		echonl('generate ' . $this->path . '/' . $filename);
		$f = fopen($this->path . '/' . $filename, 'w');
		fwrite($f, $content, strlen($content)); 
		fclose($f);
	}
}
?>
