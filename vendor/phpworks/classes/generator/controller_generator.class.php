<?php
class ControllerGenerator extends Generator {
	public $path;
	public $template = '<?php
class <class>Controller extends Controller {
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
		$this->path = Config::get()->ctrl_dir;
		$this->functions = $functions;
	}

	public function generate() {
		$this->validation();
		$this->generate_path();
		$this->generate_file();

		// make helper
		$view_generator = new HelperGenerator($this->name);
		$view_generator->generate();

		// make view
		foreach($this->functions as $function) {
			$view_generator = new ViewGenerator($this->name, $function);
			$view_generator->generate();
		}
	}

	public function get_filename() {
		return $this->name . '_controller.class.php';
	}

	public function get_functions_contents() {
		$result = '';
		foreach($this->functions as $function) {
			$result .= str_replace('<function>', $function, $this->function_template);
		}
		return $result;
	}

	public function get_contents() {
		$class = tablename_to_classname($this->name);
		$functions = $this->get_functions_contents();
		$result = str_replace('<class>', $class, $this->template);
		$result = str_replace('<functions>', $functions, $result);
		return $result;
	}
}

