<?php
class User extends ActiveRecord {

	public function validate() {
		if (is_blank($this->email)) {
			$this->errors->add('사용자 구분을 위해 이메일 주소가 필요합니다.');
			return false;
		}

		if (!is_valid_email($this->email)) {
			$this->errors->add('바른 형식의 이메일 주소가 필요합니다.');
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

		if (is_blank($this->password)) {
			$this->errors->add('비밀번호를 입력해 주세요.');
			return false;
		}

		if ($this->password != $this->repassword ) {
			$this->errors->add('두 개의 비밀번호를 서로 다르게 입력하셨습니다.');
			return false;
		}

		return true;
	}

	public function validate_register() {
		if (!$this->validate()) {
			return false;
		}

		if ($this->count("email = '{$this->email}'") > 0) {
			$this->errors->add('이미 등록되어 있는 이메일 주소입니다.');
			return false;
		}

		if ($this->count("nickname = '{$this->nickname}'") > 0) {
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

		return true;
	}

	public function validate_update($user_id) {
		if (!$this->validate()) {
			return false;
		}

		if ($this->count("id != {$user_id} AND email = '{$this->email}'") > 0) {
			$this->errors->add('이미 등록되어 있는 이메일 주소입니다.');
			return false;
		}

		if ($this->count("id != {$user_id} AND nickname = '{$this->nickname}'") > 0) {
			$this->errors->add('동일한 별명이 이미 사용되고 있습니다. 다른 별명을 입력해 주세요.');
			return false;
		}

		return true;
	}

	public function validate_leave($user_id) {
		return $this->validate_update($user_id);
	}

	public function register() {
		$this->create_new_salt();
		$this->encrypt_password($this->password, $this->salt);
		$this->save();
	}

	public function authenticate() {
		$user = $this->find(array('where' => "email = '" . $this->email . "'"));

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

	public function login($session) {
		$user = $this->find(array('where' => "email = '" . $this->email . "'"));
		$session->save('user_id', $user->id);
		$session->save('user_nickname', $user->nickname);
	}

	public function logout($session) {
		$session->delete('user_id');
		$session->delete('user_nickname');
	}

	private function create_new_salt() {
		$this->salt = uniqid() . mt_rand();
	}

	private function encrypt_password($password, $salt) {
		$this->hashed_password = sha1($password . Config::get()->crypt_key . $salt);
		return $this->hashed_password;
	}
}

