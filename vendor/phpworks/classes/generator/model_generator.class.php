<?php
class ModelGenerator extends Generator {

	// 1. mkdir app
	// 2. mkdir app/model
	// 3. generate model file
	// 4. mkdir db
	// 5. mkdir db/migrate
	// 6. generate model file
	var $name;
	var $template = "<?php
class [NAME] extends Model {

}
?>";
	var $path = 'app/model';

	function ModelGenerator($name) {
		$this->name = $name;
	}

	function generate_dir($dir) {
	}

	function generate_dir_app() {
	}

	function generate_dir_model() {
	}

	function genereate_dir_db() {
	}

	function generate_dir_migrate() {
	}

	function generate_skeleton() {
	}
}
?>
