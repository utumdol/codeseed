<?php
class BlogComment extends ActiveRecord {

	public function init() {
		$this->belongs_to('user');
		$this->belongs_to('blog');
	}

	public function validate_register() {
		if (is_blank($this->comment)) {
			$this->errors->add('댓글을 입력해 주세요.');
			return false;
		}

		return true;
	}

	public function validate_delete() {
		if (!self::neo()->where('id = ? AND user_id = ?', $this->id, User::get_login_id())->is_exists()) {
			$this->errors->add('글을 작성한 본인만 삭제할 수 있습니다.');
			return false;
		}
		return true;
	}
}

