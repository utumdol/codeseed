<?php
class UserController extends ApplicationController {

	public function __construct() {
		parent::__construct();
		$this->layout = 'blog';
	}

	public function before_filter() {
		if (in_array($this->action_name, array('register_form', 'register', 'register_success', 'login_form', 'login', 'leave_success', 'send_password_form', 'send_password', 'send_password_success'))) {
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
		$user->login();
		$this->redirect_to('/user/register_success/' . $user->nickname);
	}

	public function register_success($nickname) {
		$this->user = new User();
		$this->user->nickname = $nickname;
	}

	public function update_form() {
		$this->user = User::neo()->where(User::get_login_id())->find();
	}

	public function update() {
		// validation
		$user = new User(_post('user'));
		$user->id = User::get_login_id();
		if (!$user->validate_update()) {
			$this->flash->add('message_error', $user->errors->get_messages());
			$this->back();
		}
		$user->update();
		$user->login();

		$this->flash->add('message_success', '성공적으로 수정 되었습니다!');
		$this->redirect_to('/user/update_form');
	}

	public function leave_form() {
	}

	public function leave() {
		// get nickname to say good bye.
		$user = User::neo()->where(User::get_login_id())->find();

		// get all blog ids to delete comments
		$blogs = Blog::neo()->select('id')->where('user_id = ?', User::get_login_id())->find('all');
		$blog_ids = extract_property($blogs, 'id');

		// delete blog_comment, blog, and user
		Context::get('db')->start_transaction();
		BlogComment::neo()->where('blog_id ' . Query::id_condition($blog_ids))->delete();
		Blog::neo()->where('user_id = ?', User::get_login_id())->delete();
		User::neo()->where(User::get_login_id())->delete();
		Context::get('db')->commit();

		$user->logout();
		$this->redirect_to('/user/leave_success/' . $user->nickname);
	}

	public function leave_success($nickname) {
		$this->register_success($nickname);
	}

	public function send_password_form() {
	}

	public function send_password() {
		$this->layout = 'blank';

		$user = new User(_post('user'));
		$user->refine();

		if (!$user->validate_send_password()) {
			$this->flash->add('message_error', $user->errors->get_messages());
			$this->back();
		}

		$user = User::get_by_email($user->email);
		$user->send_password();
		$this->redirect_to('/user/send_password_success');
	}

	public function send_password_success() {
	}

	public function login_form() {
	}

	public function login() {
		$this->layout = 'blank';
		$user = new User(_post('user'));
		$user->refine();
		if (!$user->validate_login()) {
			$this->flash->add('message_error', $user->errors->get_messages());
			$this->back();
		}

		$remember_me = is_blank(_post('remember_me')) ? false : true;
		$user->login($remember_me);

		$return_url = _get('return_url');
		if (empty($return_url)) {
			$return_url = '/';
		}
		$this->redirect_to($return_url);
	}

	public function logout() {
		$user = new User();
		$user->logout();
		$this->redirect_to('/blog/index');
	}
}

