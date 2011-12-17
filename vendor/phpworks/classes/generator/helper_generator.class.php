<?php
class HelperGenerator extends Generator {
	public $path;
	public $template = '<?php

';

	public function __construct($name, $functions = array()) {
		parent::__construct($name);
		$this->path = Config::one()->help_dir;
		$this->functions = $functions;
	}
}

