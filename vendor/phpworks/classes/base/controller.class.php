<?php
class Controller {
	var $layout = 'default';

	public function load_view($view) {
		require(VIEW_DIR . '/' . $view . '.php');
	}
}

