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

	public function get_columns() {
		global $db;
		$this->columns = $db->get_table_columns($this->name);
	}

	public function insert() {
	}

	public function select() {
	}

	public function update() {
	}

	public function delete() {
	}

	private function get_select_column() {
		$result = array();
		foreach($this->columns as $column) {
			$result[] = $this->name . '__' . $column->name;
		}
		return csv($result);
	}
	
	private function get_select_result($result) {
	}
}

