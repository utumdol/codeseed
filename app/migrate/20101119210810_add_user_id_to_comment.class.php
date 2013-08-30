<?php
class AddUserIdToComment extends Migration {
	public function up() {
		$this->add_column(array('table' => 'blog_comment', 'name' => 'user_id', 'type' => 'integer', 'is_null' => false));
		$this->add_index('blog_comment', 'user_id', 'user_id');
	}

	public function down() {
		$this->remove_column('blog_comment', 'user_id');
	}
}

