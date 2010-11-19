<?php
class Controller {
	public $layout = 'default';

	public function before($action) {
		// the method which is called before excute actions
	}

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

	public function after($action) {
		// the method which is called after excute actions
	}
}

