<?php
class ControllerGenerator extends Generator {
	public $path;
	public $extention = '_controller.class.php';
	public $template = '<?php
class <class>Controller extends ApplicationController {

	public function __construct() {
		parent::__construct();
		$this->layout = \'<filename>\';
	}
	<functions>
}

';
	public $function_template = '
	public function <function>() {
	}
	';
	private $functions = '';

	public function __construct($name, $functions = array()) {
		parent::__construct($name);
		$this->path = Config::get('ctrl_dir');
		$this->functions = $functions;
	}

	public function generate() {
		if (!$this->validation()) {
			return;
		}
		$this->generate_path();
		$this->generate_file();

		// make application controller
		$generator = new ApplicationControllerGenerator();
		$generator->generate();

		// make helper
		$generator = new HelperGenerator($this->name);
		$generator->generate();

		// make layout
		$generator = new LayoutGenerator($this->name);
		$generator->generate();

		// make view
		foreach($this->functions as $function) {
			$generator = new ViewGenerator(classname_to_filename($this->name), $function);
			$generator->generate();
		}
	}

	public function get_functions_contents() {
		$result = '';
		foreach($this->functions as $function) {
			$result .= str_replace('<function>', $function, $this->function_template);
		}
		return $result;
	}

	public function get_contents() {
		$class = filename_to_classname($this->name);
		$filename = classname_to_filename($this->name);
		$functions = $this->get_functions_contents();
		$result = str_replace('<class>', $class, $this->template);
		$result = str_replace('<filename>', $filename, $result);
		$result = str_replace('<functions>', $functions, $result);
		return $result;
	}
}

