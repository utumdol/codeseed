<?php
class BlogController extends Controller {
	var $layout = 'blog';

	public function post_form() {
	}

	public function post() {
		$article = new Article($this->params['article']);
		$article->validate();
		$article->save();
		$this->redirect_to('/blog/index');
	}

	public function index($page = '1') {
		$article = new Article();
		$page_size = 7;
		$this->list = $article->find_all('', 'id DESC', $page, $page_size);
		$this->paging = new Paging($article->count(), $page_size, '/blog/index/<page>', $page);
	}

	public function view($id, $page = '1') {
		$article = new Article();
		$this->article = $article->find("id = '$id'");
	}

	public function update_form($id) {
		$article = new Article();
		$this->article = $article->find("id = '$id'");
	}

	public function update() {
		$article = new Article($this->params['article']);
		$article->validate();
		$old_article = $article->find("id = '" . $article->id . "'");
		$article->update();
		$this->redirect_to('/blog/index');
	}

	public function delete($id) {
		$article = new Article();
		$article->id = $id;
		$article->delete();
		$this->redirect_to('/blog/index');
	}
}

