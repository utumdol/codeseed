<?php
class Article extends Model {

	public function validate() {
		if (empty($this->subject)) {
			$this->errors->add('제목을 입력해 주세요.');
			return false;
		}

		if (empty($this->content)) {
			$this->errors->add('내용을 입력해 주세요.');
			return false;
		}

		return true;
	}
}

