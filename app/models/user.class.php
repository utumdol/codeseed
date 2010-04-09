<?
class User extends Model {

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

		$total = $this->get_total("string_id = '$this->string_id'");
		if ($total > 0) {
			throw new ValidationError('사용 중인 아이디입니다.');
		}
	}

	public function register() {
		$this->encrypt_passwd();
		parent::register();
	}

	public function validate_update() {
		$this->validate();
	}

	public function update() {
		$this->encrypt_passwd();
		parent::update();
	}

	private function encrypt_passwd() {
		$this->salt = rand();
		$this->passwd = md5($this->passwd . 'utumdol' . $this->salt);
	}
}
?>
