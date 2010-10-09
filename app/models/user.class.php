<?php
class User extends Model {

	public function validate() {
		if (blank($this->email)) {
			$this->errors->add('이메일을 입력해 주세요.');
			return false;
		}

		if (blank($this->nickname)) {
			$this->errors->add('별명을 입력해 주세요.');
			return false;
		}

		if (blank($this->password)) {
			$this->errors->add('비밀번호를 입력해 주세요.');
			return false;
		}

		if (blank($this->repassword)) {
			$this->errors->add('비밀번호를 입력해 주세요.');
			return false;
		}

		return true;
	}
}

