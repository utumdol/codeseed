<?php
class ViewGenerator extends Generator {
	var $dir = '';
	var $path = VIEW_DIR;
	var $template = '<h1><dir>#<view></h1>
<div>Find me in app/views/<dir>/<view>.php</div>

';

	public function ViewGenerator($dir, $name) {
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

