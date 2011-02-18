<?php
class Article extends Model {

	public function init() {
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

	public function is_writer($user_id) {
		return ($this->user_id == $user_id);
	}

	// TODO rename method to validate_update
	public function validation_update($user_id) {
		if (!$this->is_writer($user_id)) {
			$this->errors->add('글을 작성한 본인만 수정 또는 삭제할 수 있습니다.');
			return false;
		}
		return true;
	}

	// TODO rename method to validate_delete
	public function validation_delete($user_id) {
		return $this->validation_update($user_id);
	}
}

