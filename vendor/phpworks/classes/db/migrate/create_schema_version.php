<?php
class CreateSchemaVersion extends Migration {
	public function up() {
		$this->create_table('schema_version');
		$this->add_column('schema_version', 'version', 'string', false);
	}

	public function down() {
		$this->drop_table('schema_version');
	}
}

