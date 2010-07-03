<?php
class BlogController extends Controller {
	
	public function post_form() {
	}
	
	public function post() {
		$this->article = new Article();
		$this->article->created_at = time();
		$this->article->updated_at = $this->article->created_at;
		$this->article->register();
	}
}
