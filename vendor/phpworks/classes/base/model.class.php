<?php
class Model {
	public $name;
	public $errors;

	public function __construct($params = array()) {
		$this->name = get_class($this);
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

