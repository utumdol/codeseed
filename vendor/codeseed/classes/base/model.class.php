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
	 * trim string properties
	 */
	public function trim() {
		$props = get_object_vars($this);
		foreach($props as $prop => $value) {
			if (is_string($value)) {
				$this->$prop = trim($value);
			}
		}
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

	/**
	 * return model to json string
	 * @return string
	 */
	public function get_json() {
		return json_encode($this);
	}
}

