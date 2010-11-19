<?php
class AddUserIdToComment extends Migration {
	public function up() {
		$this->add_column('article_comment', 'user_id', 'integer', false);
		$this->add_index('article_comment', 'idx_user_id', 'user_id');
	}

	public function down() {
		$this->remove_column('article_comment', 'user_id');
	}
}

