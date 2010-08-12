<?php
class Migration {

	public function create_table($table_name) {
		global $db;

		$db->create_table($table_name);
	}

	public function drop_table($table_name) {
		global $db;

		$db->drop_table($table_name);
	}

	public function add_column($table_name, $name, $type, $size, $is_null = true) {
		global $db;

		$db->add_column($table_name, $name, $type, $size, $is_null = true);
	}

	public function drop_column($table_name, $name) {
		global $db;

		$db->drop_column($table_name, $name);
	}

	public function add_index($table_name, $name, $fields) {
		global $db;

		$db->add_index($table_name, $name, $fields);
	}

	public function drop_index($table_name, $name) {
		global $db;

		$db->drop_index($table_name, $name);
	}
}

