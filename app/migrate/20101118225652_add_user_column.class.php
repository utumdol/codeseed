<?php
class AddUserColumn extends Migration {
	public function up() {
		$this->add_column(array('table' => 'blog', 'name' => 'user_id', 'type' => 'integer', 'is_null' => false));
		$this->add_index('blog', 'user_id', 'user_id');
	}

	public function down() {
		$this->remove_column('blog', 'user_id');
	}
}

