<?php
class Migration {

	public function create_table($table_name) {
		Context::get('db')->create_table($table_name);
	}

	public function drop_table($table_name) {
		Context::get('db')->drop_table($table_name);
	}

	// TODO
	public function rename_table($old_name, $new_name) {
		Context::get('db')->rename_table($old_name, $new_name);
	}

	/**
	 * @param $scale the number of digits to the right of the decimal point
	 */
	public function add_column($table_name, $name, $type, $is_null = true, $size = null, $default = null, $scale = null) {
		Context::get('db')->add_column($table_name, $name, $type, $is_null, $size, $default, $scale);
	}

	public function remove_column($table_name, $name) {
		Context::get('db')->remove_column($table_name, $name);
	}

	// TODO
	public function rename_column($table_name, $old_name, $new_name) {
		Context::get('db')->rename_column($table_name, $old_name, $new_name);
	}

	public function change_column($table_name, $name, $type, $is_null = true, $size = null) {
		Context::get('db')->change_column($table_name, $name, $type, $is_null, $size);
	}

	public function add_index($table_name, $name, $columns, $is_unique = false) {
		Context::get('db')->add_index($table_name, $name, $columns, $is_unique);
	}

	public function remove_index($table_name, $name) {
		Context::get('db')->remove_index($table_name, $name);
	}
}

