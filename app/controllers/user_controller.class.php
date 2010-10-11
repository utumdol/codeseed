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
	}

	public function register_result() {
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

