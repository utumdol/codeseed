<?php
class CreateBlog extends Migration {
	public function up() {
		$this->create_table('blog');
		$this->add_column(array('table' => 'blog', 'name' => 'subject', 'type' => 'text', 'is_null' => false));
		$this->add_column(array('table' => 'blog', 'name' => 'content', 'type' => 'text', 'is_null' => false));
		$this->add_column(array('table' => 'blog', 'name' => 'created_at', 'type' => 'integer', 'is_null' => false));
		$this->add_column(array('table' => 'blog', 'name' => 'updated_at', 'type' => 'integer', 'is_null' => false));
	}

	public function down() {
		$this->drop_table('blog');
	}
}

