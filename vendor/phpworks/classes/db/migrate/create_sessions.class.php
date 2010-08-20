<?php
class CreateSessions extends Migration {
	public function up() {
		$this->create_table('sessions');
		$this->change_column('sessions', 'id', 'string', false, '32');
		$this->add_column('sessions', 'access', 'integer', true, '10');
		$this->add_column('sessions', 'data', 'text');
	}

	public function down() {
		$this->drop_table('sessions');
	}
}

