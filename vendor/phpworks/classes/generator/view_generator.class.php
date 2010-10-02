<?php
class ViewGenerator extends Generator {
	public $path = VIEW_DIR;
	public $template = '<h1><dir>#<view></h1>
<div>Find me in app/views/<dir>/<view>.php</div>

';
	private $dir = '';

	public function __construct($dir, $name) {
		parent::__construct($name);
		$this->dir = $dir;
		$this->name = $name;
	}

	public function get_path() {
		return $this->path . '/' . $this->dir;
	}

	public function get_contents() {
		$result = str_replace('<dir>', $this->dir, $this->template);
		$result = str_replace('<view>', $this->name, $result);
		return $result;
	}
}

