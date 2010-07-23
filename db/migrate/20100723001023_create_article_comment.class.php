<?php
class CreateArticleComment extends Migration {
	public function up() {
		$this->create_table('article_comment');
		$this->add_column('article_comment', 'article_id', 'int', '0', false);
		$this->add_column('article_comment', 'comment', 'text', '0', false);
		$this->add_column('article_comment', 'created_at', 'int', '0', false);
		$this->add_column('article_comment', 'updated_at', 'int', '0', false);
	}

	public function down() {
		$this->drop_table('article_comment');
	}
}

