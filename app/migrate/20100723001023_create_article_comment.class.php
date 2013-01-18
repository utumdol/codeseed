<?php
class CreateArticleComment extends Migration {
	public function up() {
		$this->create_table('article_comment');
		$this->add_column(array('table' => 'article_comment', 'name' => 'article_id', 'type' => 'integer', 'is_null' => false));
		$this->add_column(array('table' => 'article_comment', 'name' => 'comment', 'type' => 'text', 'is_null' => false));
		$this->add_column(array('table' => 'article_comment', 'name' => 'created_at', 'type' => 'integer', 'is_null' => false));
		$this->add_column(array('table' => 'article_comment', 'name' => 'updated_at', 'type' => 'integer', 'is_null' => false));
		$this->add_index('article_comment', 'idx_article_id', 'article_id');
	}

	public function down() {
		$this->drop_table('article_comment');
	}
}

