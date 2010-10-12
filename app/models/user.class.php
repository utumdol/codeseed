<?php
class User extends Model {

	public function validate() {
		if (blank($this->email)) {
			$this->errors->add('사용자 구분을 위해 이메일 주소가 필요합니다.');
			return false;
		}

		if (!is_valid_email($this->email)) {
			$this->errors->add('바른 형식의 이메일 주소가 필요합니다.');
			return false;
		}

		if (blank($this->nickname)) {
			$this->errors->add('별밍은 이 곳에서 필명으로 사용됩니다. 별명을 입력해 주세요.');
			return false;
		}

		if (blank($this->password)) {
			$this->errors->add('비밀번호를 입력해 주세요.');
			return false;
		}

		if ($this->password != $this->repassword ) {
			$this->errors->add('두 개의 비밀번호를 서로 다르게 입력하셨습니다.');
			return false;
		}

		if (!is_valid_password($this->password)) {
			$this->errors->add('비밀번호는 8자 이상, 적어도 하나 이상의 숫자와 특수문자가 있어야 안전하게 암호화됩니다.' . BN);
			$this->errors->add('ex) abcD12#$');
			return false;
		}

		return true;
	}
}

