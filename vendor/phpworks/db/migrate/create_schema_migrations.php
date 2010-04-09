<?php
class CreateSchemaMigrations extends Migration {
	public function up() {
		$this->create_table('schema_migrations');
		$this->add_column('schema_migrations', 'version', 'varchar', '255');
	}

	public function down() {
		$this->drop_table('schema_migrations');
	}
}
?>
