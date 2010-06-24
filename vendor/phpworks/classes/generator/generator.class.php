<?php
class Generator {
	private $name = '';
	private $path = '';
	private $template = '';

	public function Generator($name) {
		$this->name = $name;
	}

	public function generate() {
		$this->validation();
		$this->generatePath();
		$this->generateFile();
	}

	private function validation() {
		return true;
	}

	private function getFileName() {
		return $this->name;
	}

	private function getContents() {
		return $this->template;
	}

	private function generatePath() {
		if (is_dir($this->path)) {
			echonl('exist ' . $this->path);
		} else {
			echonl('generate ' . $this->path);
			mkdir($this->path, 0755, true);
		}
	}

	private function generateFile() {
		$filename = $this->getFileName();
		$content = $this->getContents();
		echonl('generate ' . $this->path . '/' . $filename);
		$f = fopen($this->path . '/' . $filename, 'w');
		fwrite($f, $content, strlen($content)); 
		fclose($f);
	}
}
?>
