<?php
class CreateArticle extends Migration {
	public function up() {
		$this->create_table('article');
		$this->add_column('article', 'subject', 'text', false);
		$this->add_column('article', 'content', 'text', false);
		$this->add_column('article', 'created_at', 'integer', false);
		$this->add_column('article', 'updated_at', 'integer', false);
	}

	public function down() {
		$this->drop_table('article');
	}
}

