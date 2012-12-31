<?php
class UserController extends ApplicationController {

	public function __construct() {
		parent::__construct();
		$this->layout = 'blog';
	}

	public function before_filter() {
		if (is_start_with($this->action_name, 'register') || is_start_with($this->action_name, 'login') || $this->action_name == 'leave_success') {
			return;
		}
		$this->authorize();
	}

	public function register_form() {
	}
	
	public function register() {
		$user = new User(_post('user'));
		if (!$user->validate_register()) {
			$this->flash->add('message_error', $user->errors->get_messages());
			$this->back();
		}
		$user->register();
		$user->login($this->session);
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
		$user = new User(_post('user'));
		$user->id = $this->get_login_id();
		if (!$user->validate_update($this->get_login_id())) {
			$this->flash->add('message_error', $user->errors->get_messages());
			$this->back();
		}
		$user->update();		
		$user->login($this->session);

		$this->flash->add('message_success', '성공적으로 수정 되었습니다!');
		$this->redirect_to('/user/update_form');
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
		$user = new User(_post('user'));
		if (!$user->validate_login() || !$user->authenticate()) {
			$this->flash->add('message_error', $user->errors->get_messages());
			$this->back();
		}

		$user->login($this->session);
		$return_url = _get('return_url');
		if (empty($return_url)) {
			$return_url = '/';
		}
		$this->redirect_to($return_url);
	}

	public function logout() {
		$user = new User();
		$user->logout($this->session);
		$this->redirect_to('/blog/index');
	}
}

