<?php
class ModelGenerator extends Generator {
	public $name = '';
	public  $path = MODEL_DIR;
	public $template = '<?php
class <CLASSNAME> extends Model {

}
?>';

	public function getFileName() {
		return $this->name . '.class.php';
	}

	public function getContents() {
		$classname = tablename_to_classname($this->name);
		$result = str_replace('<CLASSNAME>', $classname, $result);
		return $result;
	}
}
?>
