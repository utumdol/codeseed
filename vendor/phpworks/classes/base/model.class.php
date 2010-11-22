<?php
class Model {
	private $name;
	private $table_name;

	public $errors;

	public function __construct($params = array()) {
		$this->name = get_class($this);
		$this->table_name = classname_to_tablename($this->name);
		$this->errors = new Errors();

		foreach(array_keys($params) as $key) {
			$this->$key = $params[$key];
		}
	}

	///////////////////////////////////////////////////////////////////////////
	// DB Processing
	///////////////////////////////////////////////////////////////////////////

	/**
	 * @return true on success, false on failure
	 */
	public function save() {
		global $db;

		// load table schema and value setting
		$fields = $db->get_table_schema($this->table_name);
		$names = array();
		$values = array();
		foreach ($fields as $field) {
			$field_name = $field->name;

			if ($field_name == 'id') {
				continue;
			}
			if ($field_name == 'created_at') {
				$this->$field_name = time();
			}
			if ($field_name == 'updated_at') {
				$this->$field_name = time();
			}
			if (!isset($this->$field_name)) {
				continue;
			}

			$names[] = $field_name;
			$values[] = quotes_to_string($field->type, $db->real_escape_string(trim($this->$field_name)));
		}

		// insert
		$result = $db->insert($this->table_name, $names, $values);
		return $result;
	}

	/**
	 * @return a model object or null
	 */
	public function find($where = '') {
		if (is_null($where)) {
			return null;
		}
		if (is_numeric($where)) {
			$where = 'id = ' . $where;
		}
		$arr = $this->find_all(array('where' => $where));
		if (count($arr) > 0) {
			return $arr[0];
		}
		return null;
	}

	/**
	 * @params array.<br />
	 *	ex) array('select' => 'a, b', 'where' => 'a = b and c = d', 'group' => 'c', 'page' => 1, 'size' => 10, 'order' => 'a')
	 * @return model objects array
	 */
	public function find_all($arr = array()) {
		global $db;

		if (!array_key_exists('select', $arr)) { $arr['select'] = '*'; }
		if (!array_key_exists('from', $arr)) { $arr['from'] = $this->table_name; }
		if (!array_key_exists('where', $arr)) { $arr['where'] = ''; }
		if (!array_key_exists('group', $arr)) { $arr['group'] = ''; }
		if (!array_key_exists('page', $arr)) { $arr['page'] = ''; }
		if (!array_key_exists('size', $arr)) { $arr['size'] = ''; }
		if (!array_key_exists('order', $arr)) { $arr['order'] = ''; }

		$offset = '';
		if (array_key_exists('page', $arr) && !is_blank($arr['page'])
				&& array_key_exists('size', $arr) && !is_blank($arr['size'])) {
			$offset = ($arr['page'] - 1) * $arr['size'];
		}

		$result = $db->select($arr['select'], $arr['from'], $arr['where'],
				$arr['group'], $offset, $arr['size'], $arr['order']);

		$arr = array();	
		while ($row = $db->fetch($result)) {
			$obj = new $this->name; 
			foreach ($row as $key => $value) {
				if (is_int($key)) {
					continue;
				}
				$obj->$key = $value;
			}
			$arr[] = $obj;
		}
		$db->free_result($result);
		return $arr;
	}

	/**
	 * @return int
	 */
	public function count($where = '', $from = '') {
		global $db;

		if(is_blank($from)) {
			$from = $this->table_name;
		}

		$result = $db->select('COUNT(*) as cnt', $from, $where);

		while ($row = $db->fetch($result)) {
			$total = $row['cnt'];
		}

		$db->free_result($result);
		return $total;
	}

	/**
	 * @return true on success, false on failure
	 */
	public function update() {
		global $db;

		// load table schema and value setting
		$fields = $db->get_table_schema($this->table_name);
		$names = array();
		$values = array();
		foreach ($fields as $field) {
			$field_name = $field->name;
			if ($field_name == 'id') {
				continue;
			}
			if ($field_name == 'created_at') {
				continue;
			}
			if ($field_name == 'updated_at') {
				$this->$field_name = time();
			}
			if (!isset($this->$field_name)) {
				continue;
			}

			$names[] = $field_name;
			$values[] = quotes_to_string($field->type, $db->real_escape_string(trim($this->$field_name)));
		}

		// update
		$result = $db->update($this->table_name, $names, $values, 'id = ' . $this->id);
		return $result;
	}

	/**
	 * @return true on success, false on failure
	 */
	public function delete($where = '') {
		global $db;

		// make condition
		if (is_int(intval($where))) {
			$where = 'id = ' . $where;
		}
		$result = $db->delete($this->table_name, $where);
		return $result;
	}
}

