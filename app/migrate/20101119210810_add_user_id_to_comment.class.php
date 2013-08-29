<?php
class AddUserIdToComment extends Migration {
	public function up() {
		$this->add_column(array('table' => 'article_comment', 'name' => 'user_id', 'type' => 'integer', 'is_null' => false));
		$this->add_index('article_comment', 'user_id', 'user_id');
	}

	public function down() {
		$this->remove_column('article_comment', 'user_id');
	}
}

