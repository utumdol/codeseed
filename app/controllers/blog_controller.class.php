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
		$limit = 7;
		$offset = ($page - 1) * $limit;
		$list = $article->find_all(array('select' => 'id', 'offset' => $offset, 'limit' => $limit, 'order' => 'id DESC'));
		$ids = $this->get_ids($list);
		$where = '';
		if (is_array($ids) && count($ids) > 0) {
			$where = 'article.id in (' . csv($ids) . ')';
		}
		$this->list = $article->find_all(array('include' => array('user', 'article_comment'), 'order' => 'article.id DESC', 'where' => $where));
		$this->paging = new Paging($article->count(), $limit, '/blog/index/<page>', $page);
	}

	private function get_ids($articles) {
		$result = array();
		foreach($articles as $article) {
			$result[] = $article->id;
		}
		return $result;
	}

	public function view($id, $page = '1') {
		$article = new Article();
		$this->article = $article->find(array('include' => array('user', 'article_comment'), 'where' => 'article.id = ' . $id));
		$user_ids = array();
		foreach($this->article->article_comment as $comment) {
			$user_ids[] = $comment->user_id;
		}
		$this->users = $this->get_users($user_ids);
	}

	public function get_users($user_ids) {
		$result = array();
		if (empty($user_ids)) {
			return $result;
		}
		$user = new User();
		$users = $user->find_all(array('where' => 'id in (' . csv($user_ids). ')'));
		foreach($users as $user) {
			$result[$user->id] = $user;
		}
		return $result;
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

