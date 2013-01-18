<?php
class CreateArticle extends Migration {
	public function up() {
		$this->create_table('article');
		$this->add_column(array('table' => 'article', 'name' => 'subject', 'type' => 'text', 'is_null' => false));
		$this->add_column(array('table' => 'article', 'name' => 'content', 'type' => 'text', 'is_null' => false));
		$this->add_column(array('table' => 'article', 'name' => 'created_at', 'type' => 'integer', 'is_null' => false));
		$this->add_column(array('table' => 'article', 'name' => 'updated_at', 'type' => 'integer', 'is_null' => false));
	}

	public function down() {
		$this->drop_table('article');
	}
}

