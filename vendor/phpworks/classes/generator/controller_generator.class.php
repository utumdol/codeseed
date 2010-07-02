<?php
class ControllerGenerator extends Generator {
	var $name = '';
	var $functions = '';

	var $path = CNTR_DIR;
	var $template = '<?php
class <class> extends Controller {

	<functions>
}
';
	var $function_template = 'public function <function> {
	}

	';

	public function ControllerGenerator($name, $functions = array()) {
		$this->name = $name;
		$this->functions = $functions;
	}

	public function generate() {
		$this->validation();
		$this->generatePath();
		$this->generateFile();

		// make view
		foreach($this->functions as $function) {
			$view_generator = new ViewGenerator($this->name, $function);
			$view_generator->generate();
		}
	}

	public function getFileName() {
		return $this->name . '.class.php';
	}

	public function getFunctionsContents() {
		$result = '';
		foreach($this->functions as $function) {
			$result .= str_replace('<function>', $function, $this->function_template);
		}
		return $result;
	}

	public function getContents() {
		$class = tablename_to_classname($this->name);
		$functions = $this->getFunctionsContents();
		$result = str_replace('<class>', $class, $this->template);
		$result = str_replace('<functions>', $functions, $result);
		return $result;
	}
}

