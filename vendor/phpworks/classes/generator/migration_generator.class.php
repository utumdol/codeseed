<?php
class MigrationGenerator extends Generator {
	public $name = '';
	public $path = MIGR_DIR;
	public $template = '<?php
class Create<class> extends Migration {
	public function up() {
		$this->create_table(\'<table>\');
	}

	public function down() {
		$this->drop_table(\'<table>\');
	}
}
?>';

	public function getFileName() {
		$table = filename_to_tablename($this->name);
		$this_time = date('YmdHis');
		return $this_time . '_create_' . $table . '.class.php';
	}

	public function getContents() {
		$table = filename_to_tablename($this->name);
		$class = tablename_to_classname($this->name);
		$result = str_replace('<table>', $table, $this->template);
		$result = str_replace('<class>', $class, $result);
		return $result;
	}
}

