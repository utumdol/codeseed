<?php
class Model {
	private $name;
	private $table_name;

	private $belongs_to_array;
	private $has_one_array;
	private $has_many_array;

	public $errors;

	public function __construct($params = array()) {
		global $db;

		$this->name = get_class($this);
		$this->table_name = classname_to_tablename($this->name);
		$this->belongs_to_array = array();
		$this->has_one_array = array();
		$this->has_many_array = array();

		$this->errors = new Errors();

		foreach(array_keys($params) as $key) {
			$this->$key = $params[$key];
		}
		$this->init();
	}
	
	public function init() {
		// the method which is called after __construct
	}

	///////////////////////////////////////////////////////////////////////////
	// DB Table
	///////////////////////////////////////////////////////////////////////////

	public function belongs_to($table_name) {
		$this->belongs_to_array[] = new Table($table_name);
	}

	public function has_one($table_name) {
		$this->has_one_array[] = new Table($table_name);
	}

	public function has_many($table_name) {
		$this->has_many_array[] = new Table($table_name);
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
			return $arr[0];
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

