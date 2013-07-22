<?php
class CreateSessions extends Migration {
	public function up() {
		$this->create_table('sessions');
		$this->add_column(array('table' => 'sessions', 'name' => 'session_id', 'type' => 'string', 'is_null' => false, 'size' => '32'));
		$this->add_column(array('table' => 'sessions', 'name' => 'data', 'type' => 'text'));
		$this->add_column(array('table' => 'sessions', 'name' => 'updated_at', 'type' => 'integer'));
		$this->add_index('sessions', 'session_id', 'session_id');
	}

	public function down() {
		$this->drop_table('sessions');
	}
}

