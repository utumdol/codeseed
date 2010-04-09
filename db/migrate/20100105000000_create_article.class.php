<?php
class CreateArticle extends Migration {
	public function up() {
		$this->create_table('article');
		$this->add_column('article', 'user_id', 'varchar', '16');
		$this->add_column('article', 'subject', 'varchar', '512');
		$this->add_column('article', 'body', 'text', '0');
		$this->add_column('article', 'created_date', 'int', '11');
		$this->add_column('article', 'updated_date', 'int', '11');
	}

	public function down() {
		$this->drop_table('article');
	}
}
?>
