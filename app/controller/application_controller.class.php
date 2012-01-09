<?php
class ApplicationController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->layout = 'default';
	}

	public function authorize() {
		if (is_null($this->get_login_id())) {
			$this->flash->add('message', '로그 인이 필요합니다.');
			$this->redirect_to('/user/login_form?return_url=' . _server('REQUEST_URI'));
		}
	}

	public function get_login_id() {
		return $this->session->get('user_id');
	}
}

