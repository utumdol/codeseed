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

	/*
	public function MigrationGenerator($name) {
		$this->name = $name;
	}
	*/

	/*
	public function generate() {
		$this->validation();
		$this->generatePath();
		$this->generateFile();
	}
	*/

	/*
	private function validation() {
		return true;
	}
	*/

	private function getFileName() {
		$tablename = filename_to_tablename($this->name);
		$this_time = date('YmdHis');
		return $this_time . '_create_' . $tablename . '.class.php';
	}

	/*
	private function getContents() {
		$tablename = filename_to_tablename($this->name);
		$classname = tablename_to_classname($this->name);
		$result = str_replace('<TABLENAME>', $tablename, $this->template);
		$result = str_replace('<CLASSNAME>', $classname, $result);
		return $result;
	}
	*/

	/*
	private function generatePath() {
		if (is_dir($this->path)) {
			echonl('exist ' . $this->path);
		} else {
			echonl('generate ' . $this->path);
			mkdir($this->path, 0755, true);
		}
	}
	*/

	/*
	private function generateFile() {
		$filename = $this->getFileName();
		$content = $this->getContents();
		echonl('generate ' . $this->path . '/' . $filename);
		$f = fopen($this->path . '/' . $filename, 'w');
		fwrite($f, $content, strlen($content)); 
		fclose($f);
	}
	*/
}
?>
