<?php
class Model {
	public $model_name;
	public $errors;

	public function __construct($params = array()) {
		$this->model_name = get_class($this);
		$this->errors = new Errors();

 		if (!empty($params)) {
			foreach(array_keys($params) as $key) {
				$this->$key = $params[$key];
			} 
		}
		$this->init();
	}

	/**
	 * 'new' keyword alternative.
	 * it supports after php 5.3.0
	 */
	public static function neo() {
		$class_name = get_called_class();
		return new $class_name;
	}
	
	public function init() {
		// the method which is called after __construct
	}
}

