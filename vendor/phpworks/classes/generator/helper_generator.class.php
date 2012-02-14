<?php
class HelperGenerator extends Generator {
	protected $template = '<?php

';

	public function __construct($name, $functions = array()) {
		parent::__construct($name);
		$this->path = Config::get('help_dir');
		$this->functions = $functions;
	}
}

