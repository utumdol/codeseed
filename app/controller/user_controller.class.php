<?php
class UserController extends ApplicationController {

	public function __construct() {
		parent::__construct();
		$this->layout = 'blog';
	}

	public function before_filter() {
		if (in_array($this->action_name, array('register_form', 'register', 'register_success', 'login_form', 'login', 'leave_success'))) {
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
		$user = new User();
		$this->user = $user->where(User::get_login_id())->find();
	}

	public function update() {
		// validation
		$user = new User(_post('user'));
		$user->id = User::get_login_id();
		if (!$user->validate_update(User::get_login_id())) {
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
		$user = new User();
		$user = $user->where(User::get_login_id())->find();

		// get all article ids to delete comments
		$articles = Article::neo()->select('id')->where('user_id = ?', User::get_login_id())->find('all');
		$article_ids = extract_property($articles, 'id');

		// delete article_comment, article, and user
		Context::get('db')->start_transaction();
		ArticleComment::neo()->where('article_id ' . Query::id_condition($article_ids))->delete();
		Article::neo()->where('user_id = ?', User::get_login_id())->delete();
		User::neo()->where( User::get_login_id())->delete();
		Context::get('db')->commit();

		$user->logout();
		$this->redirect_to('/user/leave_success/' . $user->nickname);
	}

	public function leave_success($nickname) {
		$this->register_success($nickname);
	}

	public function login_form() {
	}

	public function login() {
		$user = new User(_post('user'));
		if (!$user->validate_login()) {
			$this->flash->add('message_error', $user->errors->get_messages());
			$this->back();
		}

		$user->login();
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

