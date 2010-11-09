<?php
class Controller {
	public $layout = 'default';

	public function load_view($view) {
		require(VIEW_DIR . '/' . $view . '.php');
	}

	public function back() {
		if (!empty($_SERVER['HTTP_REFERER'])) {
			$this->redirect_to($_SERVER['HTTP_REFERER']);
		}
		echo '<script type="text/javascript">history.back();</script>';
	}

	public function redirect_to($where) {
		echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
		throw new SkipProcessing();
	}
}

