<?php
class ArticleComment extends Model {

	public function init() {
		$this->belongs_to('user');
		$this->belongs_to('article');
	}

	public function validate() {
		if (is_blank($this->comment)) {
			$this->errors->add('댓글을 입력해 주세요.');
			return false;
		}

		return true;
	}
}

