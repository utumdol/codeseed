<?php
class Migration {

	public function create_table($table_name) {
		Context::get()->db->create_table($table_name);
	}

	public function drop_table($table_name) {
		Context::get()->db->drop_table($table_name);
	}

	// TODO
	public function rename_table($old_name, $new_name) {
		Context::get()->db->rename_table($old_name, $new_name);
	}

	public function add_column($table_name, $name, $type, $is_null = true, $size = null) {
		Context::get()->db->add_column($table_name, $name, $type, $is_null, $size);
	}

	public function remove_column($table_name, $name) {
		Context::get()->db->remove_column($table_name, $name);
	}

	// TODO
	public function rename_column($table_name, $old_name, $new_name) {
		Context::get()->db->rename_column($table_name, $old_name, $new_name);
	}

	public function change_column($table_name, $name, $type, $is_null = true, $size = null) {
		Context::get()->db->change_column($table_name, $name, $type, $is_null, $size);
	}

	public function add_index($table_name, $name, $columns) {
		Context::get()->db->add_index($table_name, $name, $columns);
	}

	public function remove_index($table_name, $name) {
		Context::get()->db->remove_index($table_name, $name);
	}
}

