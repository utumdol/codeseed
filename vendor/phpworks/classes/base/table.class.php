<?php
class Table {
	private $name;
	private $columns;

	private $belongs_to_relations = array();
	private $has_one_relations = array();
	private $has_many_relations = array();

	public function __construct($name) {
		$this->name = $name;
	}

	public function belongs_to($name) {
		$this->belongs_to_relations[] = new Table($name);
	}

	public function has_one($name) {
		$this->has_one_relations[] = new Table($name);
	}

	public function has_many($name) {
		$this->has_many_relations[] = new Table($name);
	}

	public function get_columns() {
		global $db;
		$this->columns = $db->get_table_columns($this->name);
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
		$columns = $db->get_table_columns($this->table_name);
		$names = array();
		$values = array();
		foreach ($columns as $column) {
			$column_name = $column->name;

			if ($column_name == 'id') {
				continue;
			}
			if ($column_name == 'created_at') {
				$this->$column_name = time();
			}
			if ($column_name == 'updated_at') {
				$this->$column_name = time();
			}
			if (!isset($this->$column_name)) {
				continue;
			}

			$names[] = $column_name;
			$values[] = quotes_to_string($column->type, $db->real_escape_string(trim($this->$column_name)));
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
		$arr = $this->find_list(array('where' => $where));
		if (count($arr) > 0) {
			return array_shift($arr);
		}
		return null;
	}

	/**
	 * @params array.<br />
	 *	ex) array('select' => 'a, b', 'where' => 'a = b and c = d', 'group' => 'c', 'page' => 1, 'size' => 10, 'order' => 'a')
	 * @return model objects array
	 */
	public function find_list($arr = array()) {
		global $db;

		if (!array_key_exists('select', $arr)) { $arr['select'] = csv($this->get_select_column()); }
		if (!array_key_exists('from', $arr)) { $arr['from'] = $this->get_select_from(); }
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

		return $this->parse_result($result);
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


	public function update() {
		global $db;

		// load table schema and value setting
		$columns = $db->get_table_columns($this->table_name);
		$names = array();
		$values = array();
		foreach ($columns as $column) {
			$column_name = $column->name;

			if ($column_name == 'id') {
				continue;
			}
			if ($column_name == 'created_at') {
				continue;
			}
			if ($column_name == 'updated_at') {
				$this->$column_name = time();
			}
			if (!isset($this->$column_name)) {
				continue;
			}

			$names[] = $column_name;
			$values[] = quotes_to_string($column->type, $db->real_escape_string(trim($this->$column_name)));
		}

		// update
		$result = $db->update($this->table_name, $names, $values, 'id = ' . $this->id);
		return $result;
	}

	public function delete($where = '') {
		global $db;

		// make condition
		if (is_int(intval($where))) {
			$where = 'id = ' . $where;
		}
		$result = $db->delete($this->table_name, $where);
		return $result;
	}

	public function get_select_column() {
		// init
		$this->get_columns();

		$result = array();
		foreach($this->columns as $column) {
			$result[] = $this->name . '.' . $column->name . ' ' . $this->name . '__' . $column->name;
		}

		foreach($this->belongs_to_relations as $table) {
			$arr = $table->get_select_column();
			$result = array_merge($result, $arr);
		}

		foreach($this->has_one_relations as $table) {
			$arr = $table->get_select_column();
			$result = array_merge($result, $arr);
		}

		foreach($this->has_many_relations as $table) {
			$arr = $table->get_select_column();
			$result = array_merge($result, $arr);
		}

		return $result;
	}

	public function get_select_from() {
		$from = $this->name;

		foreach($this->belongs_to_relations as $table) {
			$from .= ' join ' . $table->name;
			$from .= ' on ' . $table->name . '.id = ' . $this->name . '.' . $table->name . '_id';
		}

		foreach($this->has_one_relations as $table) {
			$from .= ' join ' . $table->name;
			$from .= ' on ' . $table->name . '.' . $this->name . '_id = ' . $this->name . '.id';
		}

		foreach($this->has_many_relations as $table) {
			$from .= ' left outer join ' . $table->name;
			$from .= ' on ' . $table->name . '.' . $this->name . '_id = ' . $this->name . '.id';
		}

		return $from;
	}

	public function parse_result($result) {
		global $db;

		$arr = array();
		
		while ($row = $db->fetch($result)) {
			$obj = $this->parse_result_row($row);
			$id = $obj->id;

			if (!isset($arr[$obj->id])) {
				$arr[$obj->id] = $obj;
			}

			foreach($this->belongs_to_relations as $table) {
				$obj = $table->parse_result_row($row);
				$property = $table->name;
				$arr[$id]->$property = $obj;
			}

			foreach($this->has_one_relations as $table) {
				$obj = $table->parse_result_row($row);
				$property = $table->name;
				$arr[$id]->$property = $obj;
			}

			foreach($this->has_many_relations as $table) {
				$obj = $table->parse_result_row($row);
				$property = $table->name;
				if (!isset($arr[$id]->$property)) {
					$arr[$id]->$property = array();
				}
				$arr[$id]->$property = array_merge($arr[$id]->$property, array($obj));
			}
		}
		$db->free_result($result);
		return $arr;
	}

	public function parse_result_row($row) {
		$classname = tablename_to_classname($this->name);
		$obj = new $classname;
		foreach ($row as $temp_key => $value) {
			if (is_int($temp_key)) {
				continue;
			}
			$keys = explode('__', $temp_key);
			$tablename = $keys[0];
			if ($tablename == $this->name) {
				$key = $keys[1];
				$obj->$key = $value;
			}
		}
		if (!isset($obj->id)) {
			return null;
		}
		return $obj;
	}
}

