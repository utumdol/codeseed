<?php
class ViewGenerator extends Generator {
	var $contname = '';
	var $name = '';
	var $path = VIEW_DIR;
	var $template = '<h1><CONTNAME>#<VIEWNAME></h1>
<div>hello, world</div>
';

	public function ViewGenerator($contname, $name) {
		$this->contname = $contname;
		$this->name = $name;
	}

	public function generate() {
		$this->validation();
		$this->generatePath();
		$this->generateFile();
	}

	public function getPath() {
		return $this->contname . '/' . $this->name;
	}

	public function getFileName() {
		return $this->name . '.php';
	}

	public function getContents() {
		$result = str_replace('<CLASSNAME>', $this->contname, $this->template);
		$result = str_replace('<VIEWNAME>', $this->name, $result);
		return $result;
	}
}
?>
