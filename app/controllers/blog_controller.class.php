<?php
class BlogController extends Controller {

	public function BlogController() {
		$this->layout = 'blog';
	}

	public function post_form() {
	}

	public function post() {
		$article = new Article();
		$article->validate();
		$article->save();
		$this->redirect('/blog/index');
	}

	public function index($page = '1') {
		$article = new Article();
		$page_size = 7;
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
		$article->update();
		$this->redirect('/blog/index');
	}

	public function destroy($id) {
		$article = new Article();
		$article->destroy("id = '$id'");
		$this->redirect('/blog/index');
	}
}

