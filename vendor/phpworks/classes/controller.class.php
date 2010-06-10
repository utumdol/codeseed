<?php
class Controller {
	var $layout = 'default';

	public function load_view($view) {
		require(VIEW_DIR . '/' . $view . '.php');
	}

	public function redirect($where) {
		echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
	}

	public function redirect_with_message($where, $message = '') {
		alert($message);
		$this->redirect($where);
	}
}
?>
