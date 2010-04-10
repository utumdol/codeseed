<?php
class CreateSchemaVersion extends Migration {
	public function up() {
		$this->create_table('schema_version');
		$this->add_column('schema_version', 'version', 'varchar', '255');
	}

	public function down() {
		$this->drop_table('schema_version');
	}
}
?>