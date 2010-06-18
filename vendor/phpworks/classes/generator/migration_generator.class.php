<?php
class MigrationGenerator {
	var $name = '';
	var $directory = '';
	var $template = '<?php
class CreateUser extends Migration {
	public function up() {
		$this->creat_table(\'user\');
	}

	public function down() {
		$this->drop_table(\'user\');
	}
}
?>';

	public function MigrationGenerator($name) {
		$this->name = $name;
	}
}

new MigrationGenerator('test');
?>
