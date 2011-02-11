<?php
class UserController extends Controller {
	public $layout = 'blog';

	public function before_filter($action = '') {
		if (is_start_with($action, 'register') || is_start_with($action, 'login')) {
			return;
		}
		$this->authorize();
	}

	// TODO duplication code. refers to BlogController's authorize()
	public function authorize() {
		$user = new User();
		$user = $user->find($this->get_login_id());
		if (is_null($user)) {
			$this->flash->add('message', '로그 인이 필요합니다.');
			$this->redirect_to('/user/login_form?return_url=' . $_SERVER['REQUEST_URI']);
		}
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
		$this->user = $user->find($this->get_login_id());
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
		$this->register_success($this->get_login_id());
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

	// TODO duplication code. refers to BlogController's get_login_id()
	private function get_login_id() {
		return $this->session->get('user_id');
	}
}

