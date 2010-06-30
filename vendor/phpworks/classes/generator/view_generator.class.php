<?php
class ViewGenerator extends Generator {
	var $dir = '';
	var $name = '';
	var $path = VIEW_DIR;
	var $template = '<h1><dir>#<view></h1>
<div>hello, world</div>
';

	public function ViewGenerator($dir, $name) {
		$this->dir = $dir;
		$this->name = $name;
	}

	public function generate() {
		$this->validation();
		$this->generatePath();
		$this->generateFile();
	}

	public function getPath() {
		return $this->dir . '/' . $this->name;
	}

	public function getFileName() {
		return $this->name . '.php';
	}

	public function getContents() {
		$result = str_replace('<dir>', $this->dir, $this->template);
		$result = str_replace('<view>', $this->name, $result);
		return $result;
	}
}
?>

