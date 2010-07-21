<?php
class Article extends Model {

	public function validate() {
		if (empty($this->subject)) {
			return false;
		}
		if (empty($this->content)) {
			return false;
		}
		return true;
	}
}

