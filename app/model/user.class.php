<?php
class User extends ActiveRecord {

	public function refine() {
		$this->trim();
	}

	public function validate_register() {
		if (is_blank($this->email)) {
			$this->errors->add('사용자 구분을 위해 이메일 주소가 필요합니다.');
			return false;
		}

		if (!validate_email($this->email)) {
			$this->errors->add('바른 형식의 이메일 주소가 필요합니다.');
			return false;
		}

		if (User::neo()->where("email = ?", $this->email)->count() > 0) {
			$this->errors->add('이미 등록되어 있는 이메일 주소입니다.');
			return false;
		}

		if (is_blank($this->password)) {
			$this->errors->add('비밀번호를 입력해 주세요.');
			return false;
		}

		if (is_blank($this->repassword)) {
			$this->errors->add('비밀번호 확인을 입력해 주세요.');
			return false;
		}

		if (strlen($this->repassword) < 4 || strlen($this->repassword) > 16) {
			$this->errors->add('비밀번호 확인은 4자 이상, 16자 이하로 입력해 주세요.');
			return false;
		}

		if (!validate_password($this->repassword)) {
			$this->errors->add('입력한 비밀번호 확인이 형식에 맞지 않습니다.');
			return false;
		}

		if ($this->password != $this->repassword) {
			$this->errors->add('두 개의 비밀번호가 서로 다릅니다.');
			return false;
		}

		if (is_blank($this->nickname)) {
			$this->errors->add('별명은 이 곳에서 필명으로 사용됩니다. 별명을 입력해 주세요.');
			return false;
		}

		if (mb_strlen($this->nickname) < 2) {
			$this->errors->add('사용자 구분을 위해 2글자 이상의 별명이 필요합니다.');
			return false;
		}

		if (User::neo()->where("nickname = ?", $this->nickname)->count() > 0) {
			$this->errors->add('동일한 별명이 이미 사용되고 있습니다. 다른 별명을 입력해 주세요.');
			return false;
		}

		return true;
	}

	public function register() {
		$this->create_new_salt();
		$this->encrypt_password($this->password, $this->salt);
		$this->save();
	}

	public function update($has_license = false) {
		// setting approved
		if (!is_blank($this->password)) {
			$this->create_new_salt();
			$this->encrypt_password($this->password, $this->salt);
		}
		parent::update();
	}

	public function validate_update() {
		if (is_blank($this->email)) {
			$this->errors->add('이메일을 입력해 주세요.');
			return false;
		}

		if (!validate_email($this->email)) {
			$this->errors->add('유효한 이메일이 아닙니다.');
			return false;
		}

		if (User::neo()->where('email = ? AND id != ?', $this->email, User::get_login_id())->is_exists()) {
			$this->errors->add('이미 등록된 이메일 주소입니다.');
			return false;
		}

		if (!is_blank($this->password) || !is_blank($this->repassword)) {

			if (is_blank($this->password)) {
				$this->errors->add('비밀번호를 입력해 주세요.');
				return false;
			}

			if (is_blank($this->repassword)) {
				$this->errors->add('비밀번호 확인을 입력해 주세요.');
				return false;
			}

			if (strlen($this->repassword) < 4 || strlen($this->repassword) > 16) {
				$this->errors->add('비밀번호 확인은 4자 이상, 16자 이하로 입력해 주세요.');
				return false;
			}

			if (!validate_password($this->repassword)) {
				$this->errors->add('입력한 비밀번호 확인이 형식에 맞지 않습니다.');
				return false;
			}

			if ($this->password != $this->repassword) {
				$this->errors->add('두 개의 비밀번호가 서로 다릅니다.');
				return false;
			}
		}

		if (is_blank($this->nickname)) {
			$this->errors->add('별명은 이 곳에서 필명으로 사용됩니다. 별명을 입력해 주세요.');
			return false;
		}

		if (mb_strlen($this->nickname) < 2) {
			$this->errors->add('사용자 구분을 위해 2글자 이상의 별명이 필요합니다.');
			return false;
		}

		if (User::neo()->where("nickname = ? AND id != ?", $this->nickname, User::get_login_id())->count() > 0) {
			$this->errors->add('동일한 별명이 이미 사용되고 있습니다. 다른 별명을 입력해 주세요.');
			return false;
		}

		return true;
	}

	public function validate_login() {
		if (is_blank($this->email)) {
			$this->errors->add('이메일 주소를 입력해 주세요.');
			return false;
		}

		if (is_blank($this->password)) {
			$this->errors->add('비밀번호를 입력해 주세요.');
			return false;
		}

		$user = User::neo()->where("email = ?", $this->email)->find();
		if (is_null($user)) {
			$this->errors->add('가입되지 않은 이메일 주소입니다.');
			return false;
		}

		if ($user->hashed_password != $this->encrypt_password($this->password, $user->salt)) {
			$this->errors->add('비밀번호를 잘못 입력하셨습니다.');
			return false;
		}

		return true;
	}

	public function validate_send_password() {
		if (is_blank($this->email)) {
			$this->errors->add('이메일을 입력해 주세요.');
			return false;
		}

		if (!validate_email($this->email)) {
			$this->errors->add('유효한 이메일이 아닙니다.');
			return false;
		}

		if (!(User::neo()->where('email = ?', $this->email)->is_exists())) {
			$this->errors->add('등록된 이메일이 아닙니다.');
			return false;
		}

		return true;
	}

	public function send_password() {
		Context::get('db')->start_transaction();

		// set new password
		$this->password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8);
		$this->create_new_salt();
		$this->encrypt_password($this->password, $this->salt);
		parent::update();

		// send email
		text_mail($this->email, "임시 비밀번호 발급 안내", "임시 비밀번호는 \"{$this->password}\" 입니다.");

		Context::get('db')->commit();
	}

	public function login($remember_me = false) {
		$current_cookie_params = session_get_cookie_params();
		if ($remember_me) {
			session_write_close();
			session_set_cookie_params(3600 * 24 * 7);
			session_start();
		} else {
			session_write_close();
			session_set_cookie_params($current_cookie_params['lifetime']);
			session_start();
		}

		$user = User::get_by_email($this->email);
		_session('user', $user);
	}

	public function logout() {
		_session('user', null);
	}

	public function validate_leave($user_id) {
		return $this->validate_update($user_id);
	}

	//////////////////////////////////////////////////////////////////
	// general methods
	//////////////////////////////////////////////////////////////////

	public static function get_login_user() {
		return _session('user');
	}

	public static function get_login_id() {
		return (User::is_login()) ? self::get_login_user()->id : null;
	}

	public static function is_login() {
		return (!is_null(self::get_login_user()));
	}

	public static function get_by_id($id) {
		return self::neo()->where($id)->find();
	}

	public static function get_by_email($email) {
		return self::neo()->where('email = ?', $email)->find();
	}

	//////////////////////////////////////////////////////////////////
	// private functions
	//////////////////////////////////////////////////////////////////

	private function create_new_salt() {
		$this->salt = uniqid() . mt_rand();
	}

	private function encrypt_password($password, $salt) {
		$this->hashed_password = sha1($password . Config::get('crypt_key') . $salt);
		return $this->hashed_password;
	}
}

