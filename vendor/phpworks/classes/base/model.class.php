<?php
class Model extends Table {
	private $name;
	public $errors;

	public function __construct($params = array()) {
		global $db;

		$this->name = get_class($this);
		parent::__construct(classname_to_tablename($this->name));
		$this->errors = new Errors();

		foreach(array_keys($params) as $key) {
			$this->$key = $params[$key];
		}
		$this->init();
	}
	
	public function init() {
		// the method which is called after __construct
	}
}

