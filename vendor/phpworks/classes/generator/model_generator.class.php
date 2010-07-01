<?php
class ModelGenerator extends Generator {
	var $name = '';
	var $path = MODEL_DIR;
	var $template = '<?php
class <class> extends Model {

}
?>';

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
		$class = tablename_to_classname($this->name);
		$result = str_replace('<class>', $class, $this->template);
		return $result;
	}
}

