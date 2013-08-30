<?php
class CreateBlogComment extends Migration {
	public function up() {
		$this->create_table('blog_comment');
		$this->add_column(array('table' => 'blog_comment', 'name' => 'blog_id', 'type' => 'integer', 'is_null' => false));
		$this->add_column(array('table' => 'blog_comment', 'name' => 'comment', 'type' => 'text', 'is_null' => false));
		$this->add_column(array('table' => 'blog_comment', 'name' => 'created_at', 'type' => 'integer', 'is_null' => false));
		$this->add_column(array('table' => 'blog_comment', 'name' => 'updated_at', 'type' => 'integer', 'is_null' => false));

		$this->add_index('blog_comment', 'blog_id', 'blog_id');
	}

	public function down() {
		$this->drop_table('blog_comment');
	}
}

