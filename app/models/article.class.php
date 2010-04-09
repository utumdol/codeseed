<?
class Article extends Model {

	private function validate() {
		if (!$this->is_exist('string_id')) {
			throw new ValidationError('유저 아이디가 입력되지 않았습니다.');
		}
		if (!$this->is_exist('passwd')) {
			throw new ValidationError('비밀번호가 입력되지 않았습니다.');
		}
		if (!$this->is_exist('repasswd')) {
			throw new ValidationError('확인을 위한 비밀번호가 입력되지 않았습니다.');
		}
		if (!$this->is_exist('email')) {
			throw new ValidationError('이메일이 입력되지 않았습니다.');
		}
		if (!$this->is_equal('passwd', 'repasswd')) {
			throw new ValidationError('비밀번호가 서로 다릅니다.');
		}
		if (!$this->is_valid_email('email')) {
			throw new ValidationError('이메일 형식이 맞지 않습니다.');
		}
		if (!$this->is_valid_url('homepage')) {
			throw new ValidationError('홈페이지 형식이 맞지 않습니다.');
		}
	}

	public function validate_register() {
		$this->validate();
	}

	public function validate_update() {
		$this->validate();
	}
}
?>
