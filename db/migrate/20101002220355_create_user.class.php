<?php
class CreateUser extends Migration {
	public function up() {
		$this->create_table('user');
		$this->add_column('user', 'email', 'string', false);
		$this->add_column('user', 'hashed_password', 'string', false);
		$this->add_column('user', 'nickname', 'string', false);
		$this->add_column('user', 'salt', 'string', false);
	}

	public function down() {
		$this->drop_table('user');
	}
}

