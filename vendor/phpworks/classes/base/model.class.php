<?php
class Model {
	var $database;
	var $name;
	var $table_name;

	public function Model() {
		global $DATABASE;

		$this->database = $DATABASE;
		$this->name = get_class($this);
		$this->table_name = classname_to_tablename($this->name);
		
		if (array_key_exists($this->name, $_POST)) {
			foreach(array_keys($_POST[$this->name]) as $key) {
				$this->$key = $_POST[$this->name][$key];
			}
		}
	}

	///////////////////////////////////////////////////////////////////////////
	// DB Processing
	///////////////////////////////////////////////////////////////////////////

	public function register() {
		// load table schema and value setting
		$fields = $this->database->get_table_schema($this->table_name);
		$names = array();
		$values = array();
		foreach ($fields as $field) {
			if ($field->name == 'id') {
				continue;
			}
			$field_name = $field->name;
			$names[] = $field_name;
			$values[] = quotes_to_string($field->type, $this->$field_name);
		}

		// insert
		$query = 'INSERT INTO ' . $this->table_name . ' (' . implode(', ', $names) . ') VALUES (' . implode(', ', $values) . ')';
		$result = $this->database->execute($query);
	}

	public function get($where = '') {
		$arr = $this->get_list($where);
		return $arr[0];
	}

	public function get_list($where = '', $order = '', $page = '', $size = '') {
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

		$result = $this->database->execute('SELECT * FROM ' . $this->table_name . ' ' . $where . ' ' . $order . ' ' . $limit);
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

	public function get_total($where = '') {
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
			if ($field->name == 'id') {
				continue;
			}
			$field_name = $field->name;
			$value = quotes_to_string($field->type, $this->$field_name);
			$pairs[] = "$field_name = $value";
		}

		// insert
		$query = 'UPDATE ' . $this->table_name . ' SET ' . implode(', ', $pairs) . ' WHERE id = ' . $this->id;
		$result = $this->database->execute($query);
	}

	public function remove($where = '') {
		// make condition
		if (!empty($where)) {
			$where = 'WHERE ' . $where;
		}

		// delete
		$query = 'DELETE FROM ' . $this->table_name . ' ' . $where;
		$this->database->execute($query);
	}
}
?>
