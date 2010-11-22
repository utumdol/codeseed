<?php
class Association {
	private $table_name;
	private $foreign_key;

	public function __construct($table_name, $foreign_key = '') {
		$this->table_name = $table_name;
		$this->foreign_key = $foreign_key;
	}
}

