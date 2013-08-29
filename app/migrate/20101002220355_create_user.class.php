<?php
class CreateUser extends Migration {
	public function up() {
		$this->create_table('user');
		$this->add_column(array('table' => 'user', 'name' => 'email', 'type' => 'string', 'is_null' => false));
		$this->add_column(array('table' => 'user', 'name' => 'hashed_password', 'type' => 'string', 'is_null' => false));
		$this->add_column(array('table' => 'user', 'name' => 'nickname', 'type' => 'string', 'is_null' => false));
		$this->add_column(array('table' => 'user', 'name' => 'salt', 'type' => 'string', 'is_null' => false));

		$this->add_index('user', 'email', 'email');
		$this->add_index('user', 'nickname', 'nickname');
	}

	public function down() {
		$this->drop_table('user');
	}
}

