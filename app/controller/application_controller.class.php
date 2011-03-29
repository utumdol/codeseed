<?php
class ApplicationController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->layout = 'blog';
	}

	public function authorize() {
		if (is_null($this->get_login_id())) {
			$this->flash->add('message', '로그 인이 필요합니다.');
			$this->redirect_to('/user/login_form?return_url=' . Context::get()->server['REQUEST_URI']);
		}
	}

	private function get_login_id() {
		return $this->session->get('user_id');
	}
}

