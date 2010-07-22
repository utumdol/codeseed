<?php
class BlogController extends Controller {
	var $layout = 'blog';

	public function post_form() {
	}

	public function post() {
		global $params;
		global $flash;

		$article = new Article($params['article']);
		if ($article->validate()) {
			$article->save();
			$this->redirect_to('/blog/index');
		} else {
			$flash->add('message', $article->errors->get_messages());
			$this->back();
		}
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
		global $flash;

		$article = new Article($params['article']);
		if ($article->validate()) {
			$article->update();
			$this->redirect_to('/blog/index');
		} else {
			$flash->add('message', $article->errors->get_messages());
			$this->back();
		}
	}

	public function delete($id) {
		$article = new Article();
		$article->id = $id;
		$article->delete();
		$this->redirect_to('/blog/index');
	}
}

