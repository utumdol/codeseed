<?php
class Article extends Model {

	public function before() {
		$this->belongs_to('user');
		$this->has_many('article_comment');
	}

	public function validate() {
		if (is_blank($this->subject)) {
			$this->errors->add('제목을 입력해 주세요.');
			return false;
		}

		if (is_blank($this->content)) {
			$this->errors->add('내용을 입력해 주세요.');
			return false;
		}

		return true;
	}
}

