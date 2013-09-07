<?php
class Blog extends ActiveRecord {

	public function init() {
		$this->belongs_to('user');
		$this->has_many('blog_comment');
	}

	public function validate_register() {
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

	public function is_writer($user_id) {
		return ($this->user_id == $user_id);
	}

	public function validate_update() {
		if (!$this->validate_register()) {
			return false;
		}

		if (!self::neo()->where('id = ? AND user_id = ?', $this->id, User::get_login_id())->is_exists()) {
			$this->errors->add('글을 작성한 본인만 수정할 수 있습니다.');
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

	public function delete() {
		Context::get('db')->start_transaction();
		// delete blog comment
		BlogComment::neo()->where('blog_id = ?', $this->id)->delete();
		// delete blog
		parent::delete();
		Context::get('db')->commit();
	}
}

