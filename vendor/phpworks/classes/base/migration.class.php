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

	// TODO
	public function rename_table($old_name, $new_name) {
		global $db;
		$db->rename_table($old_name, $new_name);
	}

	public function add_column($table_name, $name, $type, $is_null = true, $size = null) {
		global $db;
		$db->add_column($table_name, $name, $type, $is_null, $size);
	}

	public function remove_column($table_name, $name) {
		global $db;
		$db->remove_column($table_name, $name);
	}

	// TODO
	public function rename_column($table_name, $old_name, $new_name) {
		global $db;
		$db->rename_column($table_name, $old_name, $new_name);
	}

	public function change_column($table_name, $name, $type, $is_null = true, $size = null) {
		global $db;
		$db->change_column($table_name, $name, $type, $is_null, $size);
	}

	public function add_index($table_name, $name, $fields) {
		global $db;
		$db->add_index($table_name, $name, $fields);
	}

	public function remove_index($table_name, $name) {
		global $db;
		$db->remove_index($table_name, $name);
	}
}

