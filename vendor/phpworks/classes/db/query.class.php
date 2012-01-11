<?php
/**
 * query repository or parameter<br/>
 * for select or delete
 */
class Query {
	public $select = '';
	public $from = '';
	public $offset = '0';
	public $limit = '';
	public $join = '';
	public $joins = array();
	public $where = '';
	public $group = '';
	public $having = '';
	public $order = '';

	public $params = array();

	// for insert and update
	public $column_names = array();
	public $values = array();

	public function __construct($from) {
		$this->from = $from;
	}

	public function select($select) {
		$this->select = $select;
	}

	public function from($from) {
		$this->from = $from;
	}

	public function join($model, $join, $on = '', $params = array()) {
		$this->joins[] = $join;
		$this->params = array_merge($this->params, $params);

		// make join
		foreach($model->belongs_to_relations as $relation) {
			if ($relation->tablename == $join) {
				$this->join .= ' JOIN ' . $relation->tablename;
				if (empty($on)) {
					$this->join .= ' ON ' . $relation->tablename . '.id = ' . $model->tablename . '.' . $relation->tablename . '_id';
				} else {
					$this->join .= ' ON ' . $on;
				}
				return;
			}
		}

		foreach($model->has_one_relations as $relation) {
			if ($relation->tablename == $join) {
				$this->join .= ' JOIN ' . $relation->tablename;
				if (empty($on)) {
					$this->join .= ' ON ' . $relation->tablename . '.' . $model->tablename . '_id = ' . $model->tablename . '.id';
				} else {
					$this->join .= ' ON ' . $on;
				}
				return;
			}
		}

		foreach($model->has_many_relations as $relation) {
			if ($relation->tablename == $join) {
				$this->join .= ' LEFT OUTER JOIN ' . $relation->tablename;
				if (empty($on)) {
					$this->join .= ' ON ' . $relation->tablename . '.' . $model->tablename . '_id = ' . $model->tablename . '.id';
				} else {
					$this->join .= ' ON ' . $on;
				}
				return;
			}
		}
	}

	public function where($where, $params = array()) {
		// '$where' is empty?
		if (!is_array($where) && empty($where)) {
			return;
		}
		// '$where' is id?
		if (is_numeric($where) || is_numeric_array($where)) {
			$this->where = "{$this->from}.id" . Query::make_id_condition($where);
			return;
		}
		// etc
		$this->where = $where;

		// make params
		if (!is_array($params)) {
			$params = array($params);
		}
		$this->params = array_merge($this->params, $params);
	}

	public function group($group, $having ='', $params = array()) {
		$this->group = $group;
		$this->having = $having;
		$this->params = array_merge($this->params, $params);
	}

	public function order($order) {
		$this->order = $order;
	}

	public function limit($param1, $param2 = '') {
		if (strlen($param2) == 0) {
			$this->limit = '?';
			$this->params[] = $param1;
			return;
		}
		$this->offset = '?';
		$this->limit = '?';
		$this->params[] = $param1;
		$this->params[] = $param2;
	}

	public function set($column_name, $value) {
		$this->column_names[] = $column_name;
		$this->values[] = '?';
		$this->params[] = $value;
	}

	public static function make_id_condition($id) {
		if (!is_array($id)) {
			return " = {$id}";
		}
		if (empty($id)) {
			// always nothing
			return " = 1 AND 0 = 1";
		}
		return " IN (" . csv($id) . ')';
	}
}

