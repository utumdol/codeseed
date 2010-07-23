<?php
class ArticleComment extends Model {

	public function validate() {
		if (empty($this->comment)) {
			$this->errors->add('댓글을 입력해 주세요.');
			return false;
		}

		return true;
	}
}

