<?php
class Article extends Model {

	public function validate() {
		if (empty($this->subject)) {
			global $flash;
			$flash->add('message', '제목이 입력되지 않았습니다.');
			redirect_to('/blog/post_form');
		}
		if (empty($this->content)) {
			global $flash;
			$flash->add('message', '내용이 입력되지 않았습니다.');
			redirect_to('/blog/post_form');
		}
	}
}

