<?php
class CreateSession extends Migration {
	public function up() {
		$this->create_table('session');
		$this->change_column('session', 'id', 'string', false, '32');
		$this->add_column('session', 'access', 'integer', '10');
		$this->add_column('session', 'data', 'text');
	}

	public function down() {
		$this->drop_table('session');
	}
}

