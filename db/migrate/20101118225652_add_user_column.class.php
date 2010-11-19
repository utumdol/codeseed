<?php
class AddUserColumn extends Migration {
	public function up() {
		$this->add_column('article', 'user_id', 'integer', false);
		$this->add_index('article', 'idx_user_id', 'user_id');
	}

	public function down() {
		$this->remove_column('article', 'user_id');
	}
}

