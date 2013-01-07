<?php
/**
 * DB Table Mapper.<br/>
 * It supports for the associations of the tables.
 */
class ActiveRecord extends Model {
	public $tablename;
	public $foregin_key;
	public $columns;

	public $belongs_to_relations = array();
	public $has_one_relations = array();
	public $has_many_relations = array();

	private $query;

	public function __construct($params = array()) {
		parent::__construct($params);
		$this->tablename = camel_to_under($this->model_name);
		$this->query = new Query($this->tablename);
	}

	// I reference $tablename
	// I.$tablename_id = $tablename.id
	public function belongs_to($tablename, $foregin_key = null) {
		$active_record = new ActiveRecord();
		$active_record->tablename = $tablename;
		$active_record->foregin_key = $foregin_key;
		$this->belongs_to_relations[] = $active_record;
	}

	// $tablename reference me
	// $tablename.me_id = me.id
	public function has_one($tablename, $foregin_key = null) {
		$active_record = new ActiveRecord();
		$active_record->tablename = $tablename;
		$active_record->foregin_key = $foregin_key;
		$this->has_one_relations[] = $active_record;
	}

	public function has_many($tablename, $foregin_key = null) {
		$active_record = new ActiveRecord();
		$active_record->tablename = $tablename;
		$active_record->foregin_key = $foregin_key;
		$this->has_many_relations[] = $active_record;
	}

	public function get_columns() {
		$db = Context::get('db');
		$this->columns = $db->get_table_columns($this->tablename);
	}

	///////////////////////////////////////////////////////////////////////////
	// DB Query
	///////////////////////////////////////////////////////////////////////////

	public function select($select) {
		$this->query->select($select);
		return $this;
	}

	public function from($from) {
		$this->query->from($from);
		return $this;
	}

	public function join(/* variable arguments */) {
		$join = func_get_arg(0);
		if (func_num_args() == 1) {
			$on = '';
			$params = array();
		} else {
			$on = func_get_arg(1);
			$params = array_slice(func_get_args(), 2);
		}

		$this->query->join($this, $join, $on, $params);
		return $this;
	}

	public function where(/* variable arguments */) {
		$where = func_get_arg(0);
		$params = array_slice(func_get_args(), 1);
		if (count($params) > 0 && is_array($params[0])) {
			$params = $params[0];
		}
		$this->query->where($where, $params);
		return $this;
	}

	public function group($group, $having ='', $params = array()) {
		/*
		$group = func_get_arg(0);
		if (func_num_args() == 1) {
			$having = '';
			$params = array();
		} else {
			$having = func_get_arg(1);
			$params = array_slice(func_get_args(), 2);
		}
		*/

		$this->query->group($group, $having, $params);
		return $this;
	}

	public function order($order) {
		$this->query->order($order);
		return $this;
	}

	public function limit($param1, $param2= '') {
		$this->query->limit($param1, $param2);
		return $this;
	}

	public function set($column_name, $value) {
		$this->query->set($column_name, $value);
		return $this;
	}

	///////////////////////////////////////////////////////////////////////////
	// DB Processing
	///////////////////////////////////////////////////////////////////////////

	/**
	 * @param $option 'first' or 'all'
	 * @return when $option is 'first', then returns object or null.
	 *			when $option is 'all', then returns array.
	 */
	public function find($option = 'first') {
		$db = Context::get('db');

		// init query
		if (empty($this->query->select)) { $this->query->select = csv($this->get_select_column($this->query->joins)); }
		/*
		if ($option == 'first') {
			$this->query->limit = 1;
		}
		*/

		// get result
		$result = $db->select($this->query);

		// cleans up query object
		$this->query = new Query($this->tablename);

		// return result
		$result = $this->parse_result($result);
		if ($option == 'first') {
			return ((count($result) > 0) ? $result[0] : null);
		}
		return $result;
	}

	/**
	 * @return int
	 */
	public function count() {
		$obj = $this->select('COUNT(*) as cnt')->find();
		return $obj->cnt;
	}

	/**
	 * @return boolean
	 */
	public function is_exists() {
		return ($this->count() > 0);
	}

	public static function find_by_sql($query = '') {
		$results = array();
		$db = Context::get('db');
		$result = $db->execute($query);
		while($row = $db->fetch($result)) {
			$results[] = $row;
		}
		$db->free_result($result);
		return $results;
	}

	/**
	 * @return true on success, false on failure
	 */
	public function delete() {
		$db = Context::get('db');

		// delete
		$result = $db->delete($this->query);

		// cleans up query object
		$this->query = new Query($this->tablename);

		return $result;
	}

	/**
	 * @return true on success, false on failure
	 */
	public function save() {
		$db = Context::get('db');

		if (empty($this->query->column_names)) {
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
				if (!property_exists($this, $column_name)) {
					continue;
				}

				$this->query->set($column_name, $db->get_value($column->type, $this->$column_name));
			}
		}

		// insert
		$result = $db->insert($this->query);

		// cleans up query object
		$this->query = new Query($this->tablename);

		return $result;
	}

	public function update() {
		$db = Context::get('db');

		if (empty($this->query->column_names)) {
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
				if (!property_exists($this, $column_name)) {
					continue;
				}

				$this->query->set($column_name, $db->get_value($column->type, $this->$column_name));
			}
			if (property_exists($this, 'id')) {
				$this->query->where($this->id);
			}
		}

		// update
		$result = $db->update($this->query);

		// cleans up query object
		$this->query = new Query($this->tablename);

		return $result;
	}

	//////////////////////////////////////////////////////////////////////////////
	// DB Processing Helpers
	//////////////////////////////////////////////////////////////////////////////

	private function get_select_column($joins = array()) {
		// init
		$result = array();
		$result = array_merge($result, $this->make_select_column($this));

		foreach($this->belongs_to_relations as $table) {
			if (!in_array($table->tablename, $joins)) {
				continue;
			}
			$result = array_merge($result, $this->make_select_column($table));
		}

		foreach($this->has_one_relations as $table) {
			if (!in_array($table->tablename, $joins)) {
				continue;
			}
			$result = array_merge($result, $this->make_select_column($table));
		}

		foreach($this->has_many_relations as $table) {
			if (!in_array($table->tablename, $joins)) {
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

	/**
	 * parsing query result and return model object
	 * @param 
	 * @return model object
	 */
	private function parse_result($result) {
		$db = Context::get('db');

		$arr = array();
		
		while ($row = $db->fetch($result)) {
			Log::debug('[' . join($row, ', ') . ']');
			$obj = $this->make_object($row, $this->tablename);

			if (isset($old_obj) && $old_obj->id == $obj->id) {
				$obj = $old_obj;
			} else {
				$arr[] = $obj;
			}

			foreach($this->belongs_to_relations as $table) {
				$relation_obj = $this->make_object($row, $table->tablename);
				//if ($relation_obj == null) {
				//	continue;
				//}
				$property = $table->tablename;
				$obj->$property = $relation_obj;
			}

			foreach($this->has_one_relations as $table) {
				$relation_obj = $this->make_object($row, $table->tablename);
				//if ($relation_obj == null) {
				//	continue;
				//}
				$property = $table->tablename;
				$obj->$property = $relation_obj;
			}

			foreach($this->has_many_relations as $table) {
				$relation_obj = $this->make_object($row, $table->tablename);
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
	 * make one result row to one object
	 * @param $row - db result row
	 * @param $tablename - table name
	 * @return model object or relation model object
	 */
	private function make_object($row, $tablename) {
		$classname = under_to_camel($tablename);
		$obj = new $classname;
		$has_property = false;
		foreach ($row as $column => $value) {
			if (is_int($column)) {
				continue;
			}
			$aliases = explode('__', $column);
			// if there is no virtual aliases...
			if (count($aliases) < 2) {
				$aliases[1] = $aliases[0];
				$aliases[0] = $this->tablename;
			}
			$tablename_alias = $aliases[0];
			if ($tablename_alias == $tablename) {
				$column_alias = $aliases[1];
				$obj->$column_alias = $value;
				if (!is_null($value)) {
					$has_property = true;
				}
			}
		}
		if ($has_property) {
			return $obj;
		}
		return null;
	}

	/**
	 * return id array from result
	 */
	public static function get_ids_from_result($result, $prop = 'id') {
		$ids = array();
		
		if (empty($result)) {
			return $ids;
		}
		
		foreach($result as $row) {
			$ids[] = $row->$prop;
		}
		return $ids;
	}
}

