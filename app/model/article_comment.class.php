<?php
class ArticleComment extends ActiveRecord {

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

	public function is_writer($user_id) {
		return ($this->user_id == $user_id);
	}

	public function validation_delete($user_id) {
		if (!$this->is_writer($user_id)) {
			$this->errors->add('글을 작성한 본인만 수정 또는 삭제할 수 있습니다.');
			return false;
		}
		return true;
	}
}

