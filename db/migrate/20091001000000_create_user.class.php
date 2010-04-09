<?php
class CreateUser extends Migration {
	public function up() {
		$this->create_table('user');
		$this->add_column('user', 'string_id', 'varchar', '16');
		$this->add_column('user', 'passwd', 'varchar', '32');
		$this->add_column('user', 'email', 'varchar', '512');
		$this->add_column('user', 'homepage', 'varchar', '512', true);
		$this->add_column('user', 'intro', 'text', '0', true);
	}

	public function down() {
		$this->drop_table('user');
	}
}
?>
