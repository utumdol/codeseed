<?php
class Article extends Model {

	public function validate() {
		if (blank($this->subject)) {
			$this->errors->add('제목을 입력해 주세요.');
			return false;
		}

		if (blank($this->content)) {
			$this->errors->add('내용을 입력해 주세요.');
			return false;
		}

		return true;
	}
}

