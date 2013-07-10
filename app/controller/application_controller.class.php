<?php
class ApplicationController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->layout = 'default';
	}

	public function authorize() {
		if (is_null(User::get_login_id())) {
			$this->flash->add('message_error', '로그 인이 필요합니다.');
			$this->redirect_to('/user/login_form?return_url=' . _server('REQUEST_URI'));
		}
	}
}

