<?php
class ControllerGenerator extends Generator {
	var $name = '';
	var $path = CONT_DIR;
	var $template = '<?php
class <CLASSNAME> extends Controller {
	<METHODS>
}
?>';

	var $method_template = 'public function <METHOD> {
	}';

	public function generate() {
		$this->validation();
		$this->generatePath();
		$this->generateFile();

		$migration_generator = new MigrationGenerator($this->name);
		$migration_generator->generate();
	}

	public function getFileName() {
		return $this->name . '.class.php';
	}

	public function getContents() {
		$classname = tablename_to_classname($this->name);
		$result = str_replace('<CLASSNAME>', $classname, $this->template);
		return $result;
	}
}
?>
