<?php
class ActiveUpload extends Model {

	//////////////////////////////////////////////////////////////////
	// init
	//////////////////////////////////////////////////////////////////
	private static $DIR_GROUP_SIZE = 1000;

	/**
	 * 허용된 MIME TYPE
	 */
	protected $validate_types = array(
			//'image/jpeg',
			//'image/pjpeg'
	);

	/**
	 * 허용된 확장자.
	 * 대소문자 구분 없음
	 */
	protected $validate_extensions = array(
			// 'jpg'
	);

	public $max_upload_size = 10485760; // byte

	public function set($id, $upload_file = null) {
		$this->id = $id;
		if (empty($upload_file)) {
			return;
		}
		$this->name = $upload_file['name'];
		$this->type = $upload_file['type'];
		$this->size = $upload_file['size'];
		$this->tmp_name = $upload_file['tmp_name'];
		$this->error = $upload_file['error'];
	}

	//////////////////////////////////////////////////////////////////
	// validations
	//////////////////////////////////////////////////////////////////
	public function is_valid() {

		if (is_blank($this->tmp_name)) {
			$this->errors->add('파일을 선택해 주세요.');
			return false;
		}

		if (!empty($this->validate_types) && !in_array($this->type, $this->validate_types)) {
			//$this->errors->add('"' . $this->type . '"은 허용된 파일 타입이 아닙니다.');
			$this->errors->add('허용된 파일 타입이 아닙니다.');
			return false;
		}

		$names = explode('.', $this->name);
		$extension = end($names);
		if (!empty($this->validate_extensions) && !preg_grep("/$extension/i", $this->validate_extensions)) {
			//$this->errors->add('"' . end(explode('.', $this->name)) . '"은 허용된 파일 타입이 아닙니다.');
			$this->errors->add('허용된 파일 타입이 아닙니다.');
			return false;
		}

		if ($this->size > $this->max_upload_size) {
			$this->errors->add('최대 크기를 초과하였습니다.');
			return false;
		}

		if ($this->error > 0) {
			$this->errors->add('파일 업로드 중 오류가 발생하였습니다.');
			return false;
		}

		return true;
	}

	//////////////////////////////////////////////////////////////////
	// public methods
	//////////////////////////////////////////////////////////////////

	public function save() {
		$this->make_upload_dir();
		move_uploaded_file($this->tmp_name, $this->get_path());
	}

	public function delete() {
		if (file_exists($this->get_path())) {
			unlink($this->get_path());
			rmdir($this->get_upload_dir());
		}
	}

	public function update() {
		$this->delete();
		$this->save();
	}

	/**
	 * return real path
	 */
	public function get_path() {
		return $this->get_upload_dir() . '/' . $this->get_savename();
	}

	/**
	 * return relative path for url
	 */
	public function get_url($reload = false) {
		$tail = ($reload) ? '?' . filemtime($this->get_path()) : '';
		return '/upload/' . $this->get_middle_upload_dir() . '/' . $this->get_savename() . $tail;
	}

	/**
	 * 실제 파일이 업로드 되었는지 여부
	 */
	public function is_uploaded() {
		return (intval($this->error) == 0 && intval($this->size) > 0);
	}

	/**
	 * 실제 저장된 파일이  있는지 여부 확인
	 */
	public function is_exists() {
		return file_exists($this->get_path());
	}

	//////////////////////////////////////////////////////////////////
	// protected methods
	//////////////////////////////////////////////////////////////////

	protected function get_extension() {
		$arr = explode('.', $this->name);
		$size = count($arr);
		return strtolower($arr[$size - 1]);
	}

	protected function make_upload_dir() {
		if (is_dir($this->get_upload_dir())) {
			return;
		}
		$old = umask(0);
		mkdir($this->get_upload_dir(), 0337, true);
		umask($old);
	}

	//////////////////////////////////////////////////////////////////
	// private methods
	//////////////////////////////////////////////////////////////////

	private function get_middle_upload_dir() {
		$result = array();
		$result[] = camel_to_under($this->model_name);
		$result[] = intval($this->id / pow(self::$DIR_GROUP_SIZE, 3));
		$result[] = intval($this->id / pow(self::$DIR_GROUP_SIZE, 2));
		$result[] = intval($this->id / pow(self::$DIR_GROUP_SIZE, 1));
		$result[] = intval($this->id);
		return implode('/', $result);
	}

	private function get_upload_dir() {
		$result = array();
		$result[] = Config::get('upload_dir');
		$result[] = $this->get_middle_upload_dir();
		return implode('/', $result);
	}

	private function get_savename() {
		return hash('sha1', Config::get('crypt_key') . $this->id) . '.' . $this->get_extension();
	}
}

