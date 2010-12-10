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

	public function insert() {
	}

	public function select() {
		global $db;

		/*
		if (!array_key_exists('select', $arr)) { $arr['select'] = '*'; }
		*/
		print_r($this->get_select_column());
		$arr['select'] = csv($this->get_select_column());
		if (!array_key_exists('from', $arr)) { $arr['from'] = $this->name; }
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

	public function update() {
	}

	public function delete() {
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
	}

	public function parse_result($result) {
		global $db;

		$arr = array();
		
		while ($row = $db->fetch($result)) {
			$obj = $this->parse_result_row($row);
			$arr[$obj->id] = $obj;

			foreach($this->belongs_to_relations as $table) {
				$obj = $table->parse_result_row($row);
			}

			foreach($this->has_one_relations as $table) {
				$obj = $table->parse_result_row($row);
				$foreign_key = $this->name . '_id';
				$property = $table->name;
				$arr[$obj->$foreign_key]->$property = $obj;
			}

			foreach($this->has_many_relations as $table) {
				$obj = $table->parse_result_row($row);
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
			$key = $keys[1];
			$obj->$key = $value;
		}
		return $obj;
	}
}

