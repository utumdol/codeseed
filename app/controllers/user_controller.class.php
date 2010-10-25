<?php
class UserController extends Controller {
	public $layout = 'blog';
	
	public function register_form() {
	}
	
	public function register() {
		global $params;
		global $flash;

		$this->user = new User($params['user']);
		if ($this->user->validate()) {
		} else {
			$flash->add('message', $this->user->errors->get_messages());
			$this->redirect_to('/user/register_form');
		}
		$this->user->register();
		$this->redirect_to('/user/register_success/' . $this->user->nickname);
	}

	public function register_success($nickname) {
		$this->user = new User();
		$this->user->nickname = $nickname;
	}
	
	public function update_form() {
	}
	
	public function update() {
	}
	
	public function update_result() {
	}
	
	public function leave_form() {
	}
	
	public function leave() {
	}
	
	public function leave_result() {
	}
	
}

