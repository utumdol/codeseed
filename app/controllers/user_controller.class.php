<?php
class UserController extends Controller {
	public $layout = 'blog';

	public function before_filter($action = '') {
		if (is_start_with($action, 'register') || is_start_with($action, 'login')) {
			return;
		}
		$this->authorize();
	}

	// TODO The duplication of the BlogController->auhorize();
	public function authorize() {
		$user = new User();
		$user = $user->find($this->get_user_id());
		if (is_null($user)) {
			$this->flash->add('message', '로그 인이 필요합니다.');
			$this->redirect_to('/user/login_form?return_url=' . $_SERVER['REQUEST_URI']);
		}
	}

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
		$user = new User();
		$this->user = $user->find($this->get_user_id());

		// validation
		if ($this->user->validate_update($this->get_user_id())) {
			$this->flash->add('message', $this->user->errors->get_messages());
			$this->back();
		}
	}
	
	public function update() {
		echobn("난 뭐지?");
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
		$return_url = (array_key_exists('return_url', $this->params) && !empty($this->params['return_url'])) ? $this->params['return_url'] : '/';
		$this->redirect_to($return_url);
	}
	
	public function logout() {
		$this->user = new User();
		$this->user->logout($this->session);
		$this->redirect_to('/blog/index');
	}

	private function get_user_id() {
		return $this->session->get('user_id');
	}
}

