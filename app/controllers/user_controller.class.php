<?php
class UserController extends Controller {
	public $layout = 'blog';
	
	public function register_form() {
	}
	
	public function register() {
		global $params;
		global $flash;

		$this->user = new User($params['user']);
		if (!$this->user->validate()) {
			$flash->add('message', $this->user->errors->get_messages());
			$this->back();
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

	public function login_form() {
	}
	
	public function login() {
		global $params;
		global $flash;
		global $session;

		$this->user = new User($params['user']);
		if (!$this->user->validate_login() || !$this->user->authenticate()) {
			$flash->add('message', $this->user->errors->get_messages());
			$this->back();
		}
		
		$this->user->login();
		$return_url = ($session->get('return_url')) ? $session->get('return_url') : '/';
		$session->delete('return_url');
		$this->redirect_to($return_url);
	}
	
	public function logout() {
		$this->user = new User();
		$this->user->logout();
		$this->redirect_to('/blog/index');
	}
}

