<?php
class ModelGenerator extends Generator {
	public $path = MODEL_DIR;
	public $template = '<?php
class <class> extends Model {

}

';

	public function generate() {
		$this->validation();
		$this->generate_path();
		$this->generate_file();

		$migration_generator = new MigrationGenerator($this->name, 'model');
		$migration_generator->generate();
	}

	public function get_filename() {
		return $this->name . '.class.php';
	}

	public function get_contents() {
		$class = tablename_to_classname($this->name);
		$result = str_replace('<class>', $class, $this->template);
		return $result;
	}
}

