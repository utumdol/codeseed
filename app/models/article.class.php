<?php
class Article extends Model {

	public function validate() {
		if (empty($this->subject)) {
			throw new ValidationError('제목이 입력되지 않았습니다.');
		}
		if (empty($this->content)) {
			throw new ValidationError('내용이 입력되지 않았습니다.');
		}
	}
}

