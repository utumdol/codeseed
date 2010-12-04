<?php
class Table {
	private $name;
	private $columns;

	private $belongs_to_relations;
	private $has_one_relations;
	private $has_many_relations;

	public function __construct($name) {
		$this->name = $name;
	}

	public function belongs_to($name) {
		$this->belongs_to_array[] = new Table($name);
	}

	public function has_one($name) {
		$this->has_one_array[] = new Table($name);
	}

	public function has_many($name) {
		$this->has_many_array[] = new Table($name);
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
		$arr['select'] = $this->get_select_column();
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
		return $result;
	}

	public function update() {
	}

	public function delete() {
	}

	public function get_select_column() {
		$result = array();
		foreach($this->columns as $column) {
			$result[] = $this->name . '.' . $column->name . ' ' . $this->name . '__' . $column->name;
		}
		return csv($result);
	}
	
	public function parse_result($result) {
		global $db;

		$arr = array();	
		while ($row = $db->fetch($result)) {
			// $obj = new $this->name; 
			foreach ($row as $key => $value) {
				if (is_int($key)) {
					continue;
				}
				$arr[] = $key . ' => ' . $value;
				// $obj->$key = $value;
			}
			echobn(csv($arr));
			// $arr[] = $obj;
		}
		$db->free_result($result);
		return $arr;
	}

	public function parse_result_row($row) {
	}
}

