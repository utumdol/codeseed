<?php
class CreateArticleComment extends Migration {
	public function up() {
		$this->create_table('article_comment');
		$this->add_column('article_comment', 'article_id', 'integer', false);
		$this->add_column('article_comment', 'comment', 'text', false);
		$this->add_column('article_comment', 'created_at', 'integer', false);
		$this->add_column('article_comment', 'updated_at', 'integer', false);
		$this->add_index('article_comment', 'article_comment_idx', 'article_id');
	}

	public function down() {
		$this->drop_table('article_comment');
	}
}

