<?php
class BlogController extends Controller {
	var $layout = 'blog';

	public function post_form() {
	}

	public function post() {
		global $params;
		$article = new Article($params['article']);
		$article->validate();
		$article->save();
		redirect_to('/blog/index');
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
		global $params;
		$article = new Article($params['article']);
		$article->validate();
		$old_article = $article->find("id = '" . $article->id . "'");
		$article->update();
		redirect_to('/blog/index');
	}

	public function delete($id) {
		$article = new Article();
		$article->id = $id;
		$article->delete();
		redirect_to('/blog/index');
	}
}

