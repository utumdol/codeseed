<?php
class CreateSchemaVersion extends Migration {
	public function up() {
		$this->create_table('schema_version');
		$this->add_column(array('table' => 'schema_version', 'name' => 'version', 'type' => 'string', 'is_null' => false));
	}

	public function down() {
		$this->drop_table('schema_version');
	}
}

