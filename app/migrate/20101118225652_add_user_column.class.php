<?php
class AddUserColumn extends Migration {
	public function up() {
		$this->add_column(array('table' => 'article', 'name' => 'user_id', 'type' => 'integer', 'is_null' => false));
		$this->add_index('article', 'user_id', 'user_id');
	}

	public function down() {
		$this->remove_column('article', 'user_id');
	}
}

