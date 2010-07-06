<?php
class BlogController extends Controller {

	public function post_form() {
	}

	public function post() {
		$this->article = new Article();
		$this->article->validate();
		$this->article->created_at = time();
		$this->article->updated_at = $this->article->created_at;
		$this->article->register();
		$this->redirect_with_message('/blog/index', '글이 등록되었습니다.');
	}

	public function index($page = '1') {
		$article = new Article();
		$page_size = 10;
		$this->list = $article->get_list('', 'id DESC', $page, $page_size);
		$this->paging = new Paging($article->get_total(), $page_size, '/blog/index/<page>', $page);
	}
}

