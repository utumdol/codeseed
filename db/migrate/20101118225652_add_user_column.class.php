<?php
class AddUserColumn extends Migration {
	public function up() {
		$this->add_column('article', 'user_id', 'string', false);
	}

	public function down() {
		$this->remove_column('article', 'user_id');
	}
}

