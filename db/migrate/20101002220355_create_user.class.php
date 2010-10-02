<?php
class CreateUser extends Migration {
	public function up() {
		$this->create_table('user');
		$this->add_column('user', 'name', 'string');
		$this->add_column('user', 'hashed_password', 'string');
		$this->add_column('user', 'salt', 'string');
	}

	public function down() {
		$this->drop_table('user');
	}
}

