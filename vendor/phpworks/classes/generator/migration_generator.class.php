<?php
class MigrationGenerator extends Generator {
	private $name = '';
	private $path = MIGR_DIR;
	private $template = '<?php
class Create<CLASSNAME> extends Migration {
	public function up() {
		$this->create_table(\'<TABLENAME>\');
	}

	public function down() {
		$this->drop_table(\'<TABLENAME>\');
	}
}
?>';

	private function getFileName() {
		$tablename = filename_to_tablename($this->name);
		$this_time = date('YmdHis');
		return $this_time . '_create_' . $tablename . '.class.php';
	}

	private function getContents() {
		$tablename = filename_to_tablename($this->name);
		$classname = tablename_to_classname($this->name);
		$result = str_replace('<TABLENAME>', $tablename, $this->template);
		$result = str_replace('<CLASSNAME>', $classname, $result);
		return $result;
	}
}
?>
