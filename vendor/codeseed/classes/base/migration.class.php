<?php
class Migration {

	public function create_table($table) {
		Context::get('db')->create_table($table);
	}

	public function drop_table($table) {
		Context::get('db')->drop_table($table);
	}

	public function rename_table($name, $new_name) {
		Context::get('db')->rename_table($name, $new_name);
	}

	/**
	 * add column
	 * @param array $params ex) array('table' => 't1', 'name' => 'c1', 'type' => 'integer')
	 */
	public function add_column($params = array()) {
		if (!array_key_exists('is_null', $params))	{ $params['is_null'] = true;	}
		if (!array_key_exists('size', $params))		{ $params['size'] = null;		}
		if (!array_key_exists('default', $params))	{ $params['default'] = null;	}
		if (!array_key_exists('scale', $params))	{ $params['scale'] = null;		}
		Context::get('db')->add_column($params['table'], $params['name'], $params['type'], $params['is_null'], $params['size'], $params['default'], $params['scale']);
	}

	/**
	 * change column properties
	 * @param array $params ex) array('table' => 't1', 'name' => 'c1', 'new_name' => 'c2', 'type' => 'integer')
	 */
	public function change_column($params = array()) {
		if (!array_key_exists('is_null', $params))	{ $params['is_null'] = true;	}
		if (!array_key_exists('size', $params))		{ $params['size'] = null;		}
		if (!array_key_exists('default', $params))	{ $params['default'] = null;	}
		if (!array_key_exists('scale', $params))	{ $params['scale'] = null;		}
		Context::get('db')->change_column($params['table'], $params['name'], $params['new_name'], $params['type'], $params['is_null'], $params['size'], $params['default'], $params['scale']);
	}

	/**
	 * change column properties but keep column name
	 * @param array $params ex) array('table' => 't1', 'name' => 'c1', 'type' => 'integer')
	 */
	public function modify_column($params = array()) {
		if (!array_key_exists('is_null', $params))	{ $params['is_null'] = true;	}
		if (!array_key_exists('size', $params))		{ $params['size'] = null;		}
		if (!array_key_exists('default', $params))	{ $params['default'] = null;	}
		if (!array_key_exists('scale', $params))	{ $params['scale'] = null;		}
		Context::get('db')->modify_column($params['table'], $params['name'], $params['type'], $params['is_null'], $params['size'], $params['default'], $params['scale']);
	}

	public function rename_column($table, $name, $new_name) {
		Context::get('db')->rename_column($table, $name, $new_name);
	}

	public function remove_column($table, $name) {
		Context::get('db')->remove_column($table, $name);
	}

	public function add_index($table, $name, $columns, $is_unique = false) {
		Context::get('db')->add_index($table, $name, $columns, $is_unique);
	}

	public function remove_index($table, $name) {
		Context::get('db')->remove_index($table, $name);
	}
}

