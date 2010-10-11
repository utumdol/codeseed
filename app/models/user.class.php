<?php
class User extends Model {

	public function validate() {
		if (blank($this->email)) {
			$this->errors->add('이메일을 입력해 주세요.');
			return false;
		}

		if (!is_valid_email($this->email)) {
			$this->errors->add('이메일 형식이 맞지 않습니다.');
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

		if ($this->password != $this->repassword ) {
			$this->errors->add('비밀번호가 서로 다릅니다. 다시 입력해 주세요.');
			return false;
		}

		if (!is_valid_password($this->password)) {
			$this->errors->add('비밀번호는 알파벳, 숫자, 그리고 특수문자를 하나 이상 포함하여 8자 이상 사용하셔야 합니다.' . BN);
			$this->errors->add('ex) abcD12#$');
			return false;
		}

		return true;
	}
}

