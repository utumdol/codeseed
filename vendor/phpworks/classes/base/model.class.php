<?php
class Model {
	var $database;
	var $name;
	var $table_name;
	var $errors;

	public function Model($params = array()) {
		global $DATABASE;

		$this->database = $DATABASE;
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

	public function save() {
		// load table schema and value setting
		$fields = $this->database->get_table_schema($this->table_name);
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
			$values[] = quotes_to_string($field->type, $this->database->real_escape_string($this->$field_name));
		}

		// insert
		$query = 'INSERT INTO ' . $this->table_name . ' (' . implode(', ', $names) . ') VALUES (' . implode(', ', $values) . ')';
		$result = $this->database->execute($query);
	}

	public function find($where = '') {
		$arr = $this->find_all($where);
		return $arr[0];
	}

	public function find_all($where = '', $order = '', $page = '', $size = '', $group = '', $select = '*') {
		// make condition
		if (!empty($where)) {
			$where = 'WHERE ' . $where;
		}
		if (!empty($order)) {
			$order = 'ORDER BY ' . $order;
		}
		$limit = '';
		if (!empty($page) && !empty($size)) {
			$page_start = ($page - 1) * $size;
			$limit = "LIMIT $page_start, $size";
		}
		if (!empty($group)) {
			$group = 'GROUP BY ' . $group;
		}

		$result = $this->database->execute('SELECT ' . $select . ' FROM ' . $this->table_name . ' ' . $where . ' ' . $group . ' ' . $order . ' ' . $limit);
		$arr = array();	
		while ($row = $this->database->fetch($result)) {
			$obj = new $this->name; 
			foreach ($row as $key => $value) {
				if (is_int($key)) {
					continue;
				}
				$obj->$key = $value;
			}
			$arr[] = $obj;
		}
		$this->database->free_result($result);

		return $arr;
	}

	public function count($where = '') {
		// make condition
		if (!empty($where)) {
			$where = 'WHERE ' . $where;
		}
	
		$result = $this->database->execute('SELECT COUNT(*) AS cnt FROM ' . $this->table_name . ' ' . $where);

		while ($row = $this->database->fetch($result)) {
			$total = $row['cnt'];
		}

		$this->database->free_result($result);
		return $total;
	}

	public function update() {
		// load table schema and value setting
		$fields = $this->database->get_table_schema($this->table_name);
		$pairs = array();
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
			$value = quotes_to_string($field->type, $this->database->real_escape_string($this->$field_name));
			$pairs[] = "$field_name = $value";
		}

		// insert
		$query = 'UPDATE ' . $this->table_name . ' SET ' . implode(', ', $pairs) . ' WHERE id = ' . $this->id;
		$result = $this->database->execute($query);
	}

	public function delete($where = '') {
		// make condition
		if (!empty($where)) {
			$where = 'WHERE ' . $where;
		}

		// delete
		$query = 'DELETE FROM ' . $this->table_name . ' ' . $where;
		$this->database->execute($query);
	}
}

