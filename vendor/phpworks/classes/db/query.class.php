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
	public $ons = array();
	public $where = '';
	public $group = '';
	public $having = '';
	public $order = '';

	public function __construct($from) {
		$this->from = $from;
	}

	public function select($select) {
		$this->select = $select;
	}

	public function from($from) {
		$this->from = $from;
	}

	public function join($join, $on = '') {
		$this->joins[] = $join;
		$this->ons[] = $on;
	}

	public function where($where) {
		// '$where' is empty?
		if (empty($where)) {
			return;
		}
		// '$where' is id?
		if (is_numeric($where) || is_numeric_array($where)) {
			$this->where = "{$this->from}.id" . Query::make_id_condition($where);
			return;
		}
		// etc
		$this->where = $where;
	}

	public function group($group, $having ='') {
		$this->group = $group;
		$this->having = $having;
	}

	public function order($order) {
		$this->order = $order;
	}

	public function limit($param1, $param2 = '') {
		if (strlen($param2) == 0) {
			$this->limit = $param1;
			return;
		}
		$this->offset = $param1;
		$this->limit = $param2;
	}

	public static function make_id_condition($id) {
		if (is_array($id)) {
			return " IN (" . csv($id) . ')';
		}
		return " = {$id}";
	}
}

