<?php
class Controller {
	var $layout = 'default';
	var $params;

	public function Controller($params) {
		$this->params = $params;
	}

	public function load_view($view) {
		require(VIEW_DIR . '/' . $view . '.php');
	}

	public function redirect_to($where) {
		echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
	}
}

