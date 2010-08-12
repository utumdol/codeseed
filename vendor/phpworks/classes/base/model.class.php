<?php
class Model {
	var $name;
	var $table_name;
	var $errors;

	public function Model($params = array()) {
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

			$names[] = $field_name;
			$values[] = quotes_to_string($field->type, $db->real_escape_string($this->$field_name));
		}

		// insert
		$result = $db->insert($this->table_name, $names, $values);
		return $result;
	}

	/**
	 * @return a model object
	 */
	public function find($where = '') {
		$arr = $this->find_all($where);
		return $arr[0];
	}

	/**
	 * @return model objects array
	 */
	public function find_all($where = '', $order = '', $page = '', $size = '', $group = '', $select = '*') {
		global $db;

		$result = $db->select($select, $this->table_name, $where, $group, $page, $size, $order);

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
	public function count($where = '') {
		global $db;

		$result = $db->select('COUNT(*) as cnt', $this->table_name, $where);

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

			$names[] = $field_name;
			$values[] = quotes_to_string($field->type, $db->real_escape_string($this->$field_name));
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
		$result = $db->delete($this->table_name, $where);
		return $result;
	}
}

