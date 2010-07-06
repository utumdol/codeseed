<?php
class BlogController extends Controller {

	public function post_form() {
	}

	public function post() {
		$article = new Article();
		$article->validate();
		$article->created_at = time();
		$article->updated_at = $article->created_at;
		$article->register();
		$this->redirect_with_message('/blog/index', '글이 등록되었습니다.');
	}

	public function index($page = '1') {
		$article = new Article();
		$page_size = 10;
		$this->list = $article->get_list('', 'id DESC', $page, $page_size);
		$this->paging = new Paging($article->get_total(), $page_size, '/blog/index/<page>', $page);
	}

	public function view($id, $page = '1') {
		$article = new Article();
		$this->article = $article->get("id = '$id'");
	}

	public function update_form($id) {
		$article = new Article();
		$this->article = $article->get("id = '$id'");
	}

	public function update() {
		$article = new Article();
		$article->validate();
		$old_article = $article->get("id = '" . $article->id . "'");
		$article->created_at = $old_article->created_at;
		$article->updated_at = time();
		$article->update();
		$this->redirect_with_message('/blog/index', '수정이 완료되었습니다.');
	}

	public function remove($id) {
		$article = new Article();
		$article->remove("id = '$id'");
		$this->redirect_with_message('/blog/index', '삭제가 완료되었습니다.');
	}
}

