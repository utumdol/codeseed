<?php
class CreateArticle extends Migration {
	public function up() {
		$this->create_table('article');
		$this->add_column('article', 'subject', 'text', '0', FALSE);
		$this->add_column('article', 'content', 'text', '0', FALSE);
		$this->add_column('article', 'created_at', 'int', '11', FALSE);
		$this->add_column('article', 'updated_at', 'int', '11', FALSE);
	}

	public function down() {
		$this->drop_table('article');
	}
}

