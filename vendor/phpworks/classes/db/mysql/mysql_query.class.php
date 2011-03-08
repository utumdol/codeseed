<?php
class MysqlQuery {
	// common
	private $table = '';
	private $where = '';

	// for select
	private $select = '*';
	private $limit = '';
	private $join = '';
	private $group = '';
	private $having = '';

	// for delete

	// for insert
	private $columns = '';
	private $values = '';

	// for update
	private $set = '';

	// for relations
	private $belongs_to_relations = array();
	private $has_one_relations = array();
	private $has_many_relations = array();

	public function __construct($table, $belongs_to_relations = array(), $has_one_relations = array(), $has_many_relations = array()) {
		$this->table = $table;
		$this->belongs_to_relations = $belongs_to_relations;
		$this->has_one_relations = $has_one_relations;
		$this->has_many_relations = $has_many_relations;
	}

	public function select($select = '*') {
		$this->select = $select;
		return $this;
	}

	public function from($from) {
		$this->from = $from;
		return $this;
	}

	public function join($join, $on = '') {
		$this->join .= $join;
		if (!empty($on)) {
			$this->join .= ' ON ';
			$this->join .= $on;
		}
	}

	public function where($where = '') {
		$this->where = $where;
		return $this;
	}

	public function group($group = '', $having ='') {
		$this->group = $group;
		$this->having = $having;
		return $this;
	}

	public function order($order) {
		$this->order = $order;
		return $this;
	}

	public function limit($offset, $count) {
		$this->limit .= $offset;
		$this->limit .= ', ';
		$this->limit .= $count;
		return $this;
	}

	public function find() {
		$query = 'SELECT ';
		$query .= $this->select;
		$query .= ' FROM ';
		$query .= $this->table;
		if (!empty($this->where)) {
			$query .= ' WHERE ';
			$query .= $this->where;
		}
		if (!empty($this->group)) {
			$query .= ' GROUP BY ';
			$query .= $this->group;
		}
		if (!empty($this->having)) {
			$query .= ' HAVING ';
			$query .= $this->having;
		}
		if (!empty($this->order)) {
			$query .= ' ORDER BY ';
			$query .= $this->order;
		}
		if (!empty($this->limit)) {
			$query .= ' LIMIT ';
			$query .= $this->limit;
		}
		return $query;
	}

	public function delete() {
		$query = 'DELETE FROM ';
		$query .= $this->table;
		if (!empty($this->where)) {
			$query .= ' WHERE ';
			$query .= $this->where;
		}
		return $query;
	}

	public function update() {
	}
}

$mysql_query = new MysqlQuery('user');
echobn($mysql_query->select('id, email')->where('email =\'utumdol@naver.com\'')->group('id', 'id = 1')->order('email')->limit(0, 10)->find());
echobn($mysql_query->select('id, email')->where('email =\'utumdol@naver.com\'')->group('id', 'id = 1')->order('email')->limit(0, 10)->delete());

