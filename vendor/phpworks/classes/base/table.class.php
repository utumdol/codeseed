<?php
class Table {
	public $name;
	public $columns;

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
		$arr = $this->find_all(array('where' => $where));
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
	public function find_all($arr = array()) {
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

	private function get_select_column() {
		// init
		$result = array();
		$result = array_merge($result, $this->make_select_column($this));

		foreach($this->belongs_to_relations as $table) {
			$result = array_merge($result, $this->make_select_column($table));
		}

		foreach($this->has_one_relations as $table) {
			$result = array_merge($result, $this->make_select_column($table));
		}

		foreach($this->has_many_relations as $table) {
			$result = array_merge($result, $this->make_select_column($table));
		}

		return $result;
	}

	private function make_select_column($table) {
		$table->get_columns();

		$result = array();
		foreach($table->columns as $column) {
			$result[] = $table->name . '.' . $column->name . ' ' . $table->name . '__' . $column->name;
		}

		return $result;
	}

	private function get_select_from() {
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

	private function parse_result($result) {
		global $db;

		$arr = array();
		
		while ($row = $db->fetch($result)) {
			$obj = $this->parse_result_row($row, $this->name);

			if (isset($old_obj) && $old_obj->id == $obj->id) {
				$obj = $old_obj;
			} else {
				$arr[] = $obj;
			}

			foreach($this->belongs_to_relations as $table) {
				$relation_obj = $this->parse_result_row($row, $table->name);
				$property = $table->name;
				$obj->$property = $relation_obj;
			}

			foreach($this->has_one_relations as $table) {
				$relation_obj = $this->parse_result_row($row, $table->name);
				$property = $table->name;
				$obj->$property = $relation_obj;
			}

			foreach($this->has_many_relations as $table) {
				$relation_obj = $this->parse_result_row($row, $table->name);
				$property = $table->name;
				if (!isset($obj->$property)) {
					$obj->$property = array();
				}
				$obj->$property = array_merge($obj->$property, array($relation_obj));
			}

			$old_obj = $obj;
		}
		$db->free_result($result);
		return $arr;
	}

	private function parse_result_row($row, $tablename) {
		$classname = tablename_to_classname($tablename);
		$obj = new $classname;
		foreach ($row as $temp_column => $value) {
			if (is_int($temp_column)) {
				continue;
			}
			$columns = explode('__', $temp_column);
			$tablename2 = $columns[0];
			if ($tablename2 == $tablename) {
				$column = $columns[1];
				$obj->$column = $value;
			}
		}
		if (!isset($obj->id)) {
			return null;
		}
		return $obj;
	}
}

