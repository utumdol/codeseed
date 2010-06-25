<?php
class ModelGenerator extends Generator {
	var $name = '';
	var $path = MODEL_DIR;
	var $template = '<?php
class <CLASSNAME> extends Model {

}
?>';

	public function validation() {
		if (file_exists($this->path . '/' . $this->getFileName())) {
			throw new ValidationError('model ' . $this->name . ' is already exists.');
		}
	}

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
