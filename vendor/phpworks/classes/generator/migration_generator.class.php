<?php
class MigrationGenerator {
	var $name = '';
	var $path = 'db/migrate';
	var $template = '<?php
class Create<CLASS_NAME> extends Migration {
	public function up() {
		$this->creat_table(\'<TABLE_NAME>\');
	}

	public function down() {
		$this->drop_table(\'<TABLE_NAME>\');
	}
}
?>';

	public function MigrationGenerator($name) {
		$this->name = $name;
	}

	public function generatePath() {
		if (is_dir($this->path)) {
			echonl('exist ' . $this->path);
		} else {
			echonl('generate ' . $this->path);
			mkdir($this->path, 0755, true);
		}
	}
}
?>
