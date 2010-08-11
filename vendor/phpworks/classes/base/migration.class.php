<?php
class Migration {

	public function create_table($table_name) {
		global $database;

		$database->create_table($table_name);
	}

	public function drop_table($table_name) {
		global $database;

		$database->drop_table($table_name);
	}

	public function add_column($table_name, $name, $type, $size, $is_null = true) {
		global $database;

		$database->add_column($table_name, $name, $type, $size, $is_null = true);
	}

	public function drop_column($table_name, $name) {
		global $database;

		$database->drop_column($table_name, $name);
	}

	public function add_index($table_name, $name, $fields) {
		global $database;

		$database->add_index($table_name, $name, $fields);
	}

	public function drop_index($table_name, $name) {
		global $database;

		$database->drop_index($table_name, $name);
	}
}

