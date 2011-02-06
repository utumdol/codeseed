<?php
class UserController extends Controller {
	public $layout = 'blog';

	public function register_form() {
	}
	
	public function register() {
		$this->user = new User($this->params['user']);
		if (!$this->user->validate()) {
			$this->flash->add('message', $this->user->errors->get_messages());
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
		$this->user = new User($this->params['user']);
		if (!$this->user->validate_login() || !$this->user->authenticate()) {
			$this->flash->add('message', $this->user->errors->get_messages());
			$this->back();
		}
		
		$this->user->login($this->session);
		$return_url = '/';
		if ($this->session->get('return_url')) {
			$return_url = $this->session->get('return_url');
		} else if (array_key_exists('return_url', $this->params)) {
			$return_url = $this->params['return_url'];
		}
		$this->session->delete('return_url');
		$this->redirect_to($return_url);
	}
	
	public function logout() {
		$this->user = new User();
		$this->user->logout($this->session);
		$this->redirect_to('/blog/index');
	}
}

