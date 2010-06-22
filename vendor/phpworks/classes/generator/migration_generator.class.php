<?php
class MigrationGenerator {
	var $name = '';
	var $path = MIGR_DIR;
	var $template = '<?php
class Create<CLASSNAME> extends Migration {
	public function up() {
		$this->creat_table(\'<TABLENAME>\');
	}

	public function down() {
		$this->drop_table(\'<TABLENAME>\');
	}
}
?>';

	public function MigrationGenerator($name) {
		$this->name = $name;
	}

	public function validation() {
		return true;
	}

	public function generatePath() {
		if (is_dir($this->path)) {
			echonl('exist ' . $this->path);
		} else {
			echonl('generate ' . $this->path);
			mkdir($this->path, 0755, true);
		}
	}

	public function makeTemplate() {
		$tablename = $this->name;
		$classname = tablename_to_classname($this->name);
		$result = str_replace('<TABLENAME>', $tablename, $this->template);
		$result = str_replace('<CLASSNAME>', $classname, $result);
		return $result;
	}

	public function getFileName() {
	}

	public function generateTemplate() {
	}
}
?>
