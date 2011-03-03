<?php
class ActiveRecord {
	public $tablename;
	public $columns;

	private $belongs_to_relations = array();
	private $has_one_relations = array();
	private $has_many_relations = array();

	public function __construct($tablename) {
		$this->tablename = $tablename;
	}

	public function belongs_to($tablename) {
		$this->belongs_to_relations[] = new ActiveRecord($tablename);
	}

	public function has_one($tablename) {
		$this->has_one_relations[] = new ActiveRecord($tablename);
	}

	public function has_many($tablename) {
		$this->has_many_relations[] = new ActiveRecord($tablename);
	}

	public function get_columns() {
		$db = Context::get()->db;
		$this->columns = $db->get_table_columns($this->tablename);
	}

	///////////////////////////////////////////////////////////////////////////
	// DB Processing
	///////////////////////////////////////////////////////////////////////////

	/**
	 * @return true on success, false on failure
	 */
	public function save() {
		$db = Context::get()->db;

		// load table schema and value setting
		$columns = $db->get_table_columns($this->tablename);
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
		$result = $db->insert($this->tablename, $names, $values);
		return $result;
	}

	/**
	 * @return array or a model or null
	 */
	public static function find($where = '') {
		$arr = array();
		if (is_null($where)) {
			return null;
		}
		if (is_numeric($where)) {
			$arr['where'] = 'id = ' . $where;
		}
		if (is_numeric_array($where)) {
			$arr['where'] = 'id in (' . csv($where) . ')';
		}
		if (is_array($where)) {
			$arr = $where;
		}

		$modelname = get_called_class();
		$model = new $modelname;

		$result = $model->find_all($arr);
		if (count($result) > 1) {
			return $result;
		}
		if (count($result) == 1) {
			return $result[0];
		}
		return null;
	}

	/**
	 * @return return first model
	 */
	public static function find_first($arr = array()) {
		$modelname = get_called_class();
		$model = new $modelname;

		$result = $model->find_all($arr);
		if (count($result) > 0) {
			return $result[0];
		}
		return null;
	}

	/**
	 * @params array.<br />
	 *	ex) array('select' => 'a, b', 'where' => 'a = b and c = d', 'group' => 'c', 'page' => 1, 'size' => 10, 'order' => 'a')
	 * @return model objects array
	 */
	public static function find_all($arr = array()) {
		$db = Context::get()->db;

		$modelname = get_called_class();
		$model = new $modelname;

		if (!array_key_exists('include', $arr)) { $arr['include'] = array(); }
		if (!array_key_exists('select', $arr)) { $arr['select'] = csv($model->get_select_column($arr['include'])); }
		if (!array_key_exists('from', $arr)) { $arr['from'] = $model->get_select_from($arr['include']); }
		if (!array_key_exists('where', $arr)) { $arr['where'] = ''; }
		if (!array_key_exists('group', $arr)) { $arr['group'] = ''; }
		if (!array_key_exists('offset', $arr)) { $arr['offset'] = '0'; }
		if (!array_key_exists('limit', $arr)) { $arr['limit'] = ''; }
		if (!array_key_exists('order', $arr)) { $arr['order'] = ''; }

		$result = $db->select($arr['select'], $arr['from'], $arr['where'],
				$arr['group'], $arr['offset'], $arr['limit'], $arr['order']);

		return $model->parse_result($result);
	}

	/**
	 * @return int
	 */
	public static function count($where = '', $from = '') {
		$db = Context::get()->db;

		if(is_blank($from)) {
			$from = classname_to_tablename(get_called_class());
		}

		$result = $db->select('COUNT(*) as cnt', $from, $where);

		while ($row = $db->fetch($result)) {
			$total = $row['cnt'];
		}

		$db->free_result($result);
		return $total;
	}


	public function update() {
		$db = Context::get()->db;

		// load table schema and value setting
		$columns = $db->get_table_columns($this->tablename);
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
		$result = $db->update($this->tablename, $names, $values, 'id = ' . $this->id);
		return $result;
	}

	public function delete($where = '') {
		$db = Context::get()->db;

		// make condition
		if (is_numeric($where)) {
			$where = 'id = ' . $where;
		}
		$result = $db->delete($this->tablename, $where);
		return $result;
	}

	private function get_select_column($include = array()) {
		// init
		$result = array();
		$result = array_merge($result, $this->make_select_column($this));

		foreach($this->belongs_to_relations as $table) {
			if (!in_array($table->tablename, $include)) {
				continue;
			}
			$result = array_merge($result, $this->make_select_column($table));
		}

		foreach($this->has_one_relations as $table) {
			if (!in_array($table->tablename, $include)) {
				continue;
			}
			$result = array_merge($result, $this->make_select_column($table));
		}

		foreach($this->has_many_relations as $table) {
			if (!in_array($table->tablename, $include)) {
				continue;
			}
			$result = array_merge($result, $this->make_select_column($table));
		}

		return $result;
	}

	private function make_select_column($table) {
		$table->get_columns();

		$result = array();
		foreach($table->columns as $column) {
			$result[] = $table->tablename . '.' . $column->name . ' ' . $table->tablename . '__' . $column->name;
		}

		return $result;
	}

	private function get_select_from($include = array()) {
		$from = $this->tablename;

		foreach($this->belongs_to_relations as $table) {
			if (!in_array($table->tablename, $include)) {
				continue;
			}
			$from .= ' join ' . $table->tablename;
			$from .= ' on ' . $table->tablename . '.id = ' . $this->tablename . '.' . $table->tablename . '_id';
		}

		foreach($this->has_one_relations as $table) {
			if (!in_array($table->tablename, $include)) {
				continue;
			}
			$from .= ' join ' . $table->tablename;
			$from .= ' on ' . $table->tablename . '.' . $this->tablename . '_id = ' . $this->tablename . '.id';
		}

		foreach($this->has_many_relations as $table) {
			if (!in_array($table->tablename, $include)) {
				continue;
			}
			$from .= ' left outer join ' . $table->tablename;
			$from .= ' on ' . $table->tablename . '.' . $this->tablename . '_id = ' . $this->tablename . '.id';
		}

		return $from;
	}


	/**
	 * parsing query result and return model object
	 * @param 
	 * @return model object
	 */
	private function parse_result($result) {
		$db = Context::get()->db;

		$arr = array();
		
		while ($row = $db->fetch($result)) {
			$obj = $this->parse_result_row($row, $this->tablename);

			if (isset($old_obj) && $old_obj->id == $obj->id) {
				$obj = $old_obj;
			} else {
				$arr[] = $obj;
			}

			foreach($this->belongs_to_relations as $table) {
				$relation_obj = $this->parse_result_row($row, $table->tablename);
				//if ($relation_obj == null) {
				//	continue;
				//}
				$property = $table->tablename;
				$obj->$property = $relation_obj;
			}

			foreach($this->has_one_relations as $table) {
				$relation_obj = $this->parse_result_row($row, $table->tablename);
				//if ($relation_obj == null) {
				//	continue;
				//}
				$property = $table->tablename;
				$obj->$property = $relation_obj;
			}

			foreach($this->has_many_relations as $table) {
				$relation_obj = $this->parse_result_row($row, $table->tablename);
				$property = $table->tablename;
				if (!isset($obj->$property)) {
					$obj->$property = array();
				}
				if ($relation_obj == null) {
					continue;
				}
				$obj->$property = array_merge($obj->$property, array($relation_obj));
			}

			$old_obj = $obj;
		}
		$db->free_result($result);
		return $arr;
	}

	/**
	 * make result row to object
	 * @param $row - db result row
	 * @param $tablename - table name
	 * @return model object or relation model object
	 */
	private function parse_result_row($row, $tablename) {
		$classname = tablename_to_classname($tablename);
		$obj = new $classname;
		foreach ($row as $temp_column => $value) {
			if (is_int($temp_column)) {
				continue;
			}
			$columns = explode('__', $temp_column);
			// if there is no virtual aliases...
			if (count($columns) < 2) {
				$columns[1] = $columns[0];
				$columns[0] = $this->tablename;
			}
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

