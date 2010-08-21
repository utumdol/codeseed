<?php
class CreateSessions extends Migration {
	public function up() {
		$this->create_table('sessions');
		$this->add_column('sessions', 'session_id', 'string', false, '32');
		$this->add_column('sessions', 'data', 'text');
		$this->add_column('sessions', 'updated_at', 'integer');
		$this->add_index('sessions', 'sessions_idx', 'session_id');
	}

	public function down() {
		$this->drop_table('sessions');
	}
}

