<?php
class BlogController extends Controller {
	public $layout = 'blog';

	public function before_filter($action = '') {
		if ($action == 'index' || $action == 'view') {
			return;
		}
		$this->authorize();
	}

	public function authorize() {
		$user = new User();
		$user = $user->find($this->session->get('user_id'));
		if (is_null($user)) {
			$this->flash->add('message', '로그 인이 필요합니다.');
			$this->session->save('return_url', $_SERVER['REQUEST_URI']);
			$this->redirect_to('/user/login_form');
		}
	}

	public function post_form() {
	}

	public function post() {
		$article = new Article($this->params['article']);
		if ($article->validate()) {
			$article->user_id = $this->session->get('user_id');
			$article->save();
			$this->redirect_to('/blog/index');
		} else {
			$this->flash->add('message', $article->errors->get_messages());
			$this->back();
		}
	}

	public function index($page = '1') {
		$article = new Article();
		$page_size = 7;
		// TODO page, size => limit, offset으로 변경
		// TODO find, find_all, find_first => find로 정리할 것
		$list = $article->find_all(array('select' => 'id', 'page' => $page, 'size' => $page_size, 'order' => 'id DESC'));
		$ids = $this->get_ids($list);
		$this->list = $article->find_all(array('include' => array('user', 'article_comment'), 'order' => 'article.id DESC', 'where' => 'article.id in (' . csv($ids). ')'));
		$this->paging = new Paging($article->count(), $page_size, '/blog/index/<page>', $page);
	}

	private function get_ids($articles) {
		$result = array();
		foreach($articles as $article) {
			$result[] = $article->id;
		}
		return $result;
	}

	public function view($id, $page = '1') {
		// TODO 하나의 쿼리로 정리할 것
		$article = new Article();
		$this->article = $article->find($id);

		$comment = new ArticleComment();
		$this->comment_list = $comment->find_all(array('where' => "article_id = '$id'"));
	}

	public function update_form($id) {
		$article = new Article();
		$this->article = $article->find($id);
	}

	public function update() {
		$article = new Article($this->params['article']);
		if ($article->validate()) {
			$article->update();
			$this->redirect_to('/blog/index');
		} else {
			$this->flash->add('message', $article->errors->get_messages());
			$this->back();
		}
	}

	public function delete($id) {
		$article = new Article();
		// TODO delete parameter도 정리할 것
		$article->delete($id);

		$comment = new ArticleComment();
		$comment->delete('article_id = ' . $id);

		$this->redirect_to('/blog/index');
	}

	public function post_comment() {
		$comment = new ArticleComment($this->params['article_comment']);
		if ($comment->validate()) {
			$comment->user_id = $this->session->get('user_id');
			$comment->save();
		} else {
			$this->flash->add('message', $comment->errors->get_messages());
		}
		$this->redirect_to('/blog/view/' . $this->params['article_comment']['article_id']);
	}
}

