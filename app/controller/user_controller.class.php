<?php
class UserController extends ApplicationController {

	public function before_filter($action = '') {
		if (is_start_with($action, 'register') || is_start_with($action, 'login') || $action == 'leave_success') {
			return;
		}
		$this->authorize();
	}

	public function register_form() {
	}
	
	public function register() {
		$user = new User($this->params['user']);
		if (!$user->validate_register()) {
			$this->flash->add('message', $user->errors->get_messages());
			$this->back();
		}
		$user->register();
		$this->redirect_to('/user/register_success/' . $user->nickname);
	}

	public function register_success($nickname) {
		$this->user = new User();
		$this->user->nickname = $nickname;
	}
	
	public function update_form() {
		$user = new User();
		$this->user = $user->where($this->get_login_id())->find();
	}

	public function update() {
		// validation
		$user = new User($this->params['user']);
		$user->id = $this->get_login_id();
		if (!$user->validate_update($this->get_login_id())) {
			$this->flash->add('message', $user->errors->get_messages());
			$this->back();
		}
		$user->update();
		$user->login($this->session);
		$this->redirect_to('/user/update_success/' . $user->nickname);
	}

	public function update_success($nickname) {
		$this->register_success($nickname);
	}

	public function leave() {
		// get nickname to say good bye.
		$user = new User();
		$user = $user->where($this->get_login_id())->find();

		// delete user, article, and article_comment
		$user->join('article')->join('article_comment')->where($this->get_login_id())->delete();

		$user->logout($this->session);
		$this->redirect_to('/user/leave_success/' . $user->nickname);
	}

	public function leave_success($nickname) {
		$this->register_success($nickname);
	}

	public function login_form() {
	}

	public function login() {
		$user = new User($this->params['user']);
		if (!$user->validate_login() || !$user->authenticate()) {
			$this->flash->add('message', $user->errors->get_messages());
			$this->back();
		}

		$user->login($this->session);
		$return_url = (array_key_exists('return_url', $this->params) && !empty($this->params['return_url'])) ? $this->params['return_url'] : '/';
		$this->redirect_to($return_url);
	}

	public function logout() {
		$user = new User();
		$user->logout($this->session);
		$this->redirect_to('/blog/index');
	}
}

