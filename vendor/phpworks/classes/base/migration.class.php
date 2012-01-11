<?php
class Migration {

	public function create_table($table_name) {
		Context::one()->db->create_table($table_name);
	}

	public function drop_table($table_name) {
		Context::one()->db->drop_table($table_name);
	}

	// TODO
	public function rename_table($old_name, $new_name) {
		Context::one()->db->rename_table($old_name, $new_name);
	}

	public function add_column($table_name, $name, $type, $is_null = true, $size = null, $default = null) {
		Context::one()->db->add_column($table_name, $name, $type, $is_null, $size, $default);
	}

	public function remove_column($table_name, $name) {
		Context::one()->db->remove_column($table_name, $name);
	}

	// TODO
	public function rename_column($table_name, $old_name, $new_name) {
		Context::one()->db->rename_column($table_name, $old_name, $new_name);
	}

	public function change_column($table_name, $name, $type, $is_null = true, $size = null) {
		Context::one()->db->change_column($table_name, $name, $type, $is_null, $size);
	}

	public function add_index($table_name, $name, $columns, $is_unique = false) {
		Context::one()->db->add_index($table_name, $name, $columns, $is_unique);
	}

	public function remove_index($table_name, $name) {
		Context::one()->db->remove_index($table_name, $name);
	}
}

