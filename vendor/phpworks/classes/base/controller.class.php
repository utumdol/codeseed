<?php
class Controller {
	private $layout = 'default';

	public function load_view($view) {
		require(VIEW_DIR . '/' . $view . '.php');
	}

	public function back() {
		echo '"<script type="text/javascript">history.back();</script>';
	}

	public function redirect_to($where) {
		echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
	}
}

