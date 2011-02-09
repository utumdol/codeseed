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
		$user = $user->find($this->get_user_id());
		if (is_null($user)) {
			$this->flash->add('message', '로그 인이 필요합니다.');
			$this->redirect_to('/user/login_form?return_url=' . $_SERVER['REQUEST_URI']);
		}
	}

	public function post_form() {
	}

	public function post() {
		$article = new Article($this->params['article']);
		if ($article->validate()) {
			$article->user_id = $this->get_user_id();
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
		// get article
		$article = new Article();
		$this->article = $article->find(array('include' => array('user'), 'where' => 'article.id = ' . $id));

		// get article comment
		$article_comment = new ArticleComment();
		$this->comment = $article_comment->find_all(array('include' => array('user'), 'where' => 'article_comment.article_id = ' . $id, 'order' => 'article_comment.id'));
	}

	public function update_form($id) {
		$article = new Article();
		$this->article = $article->find($id);

		// validation
		if (!$this->article->validation_update($this->get_user_id())) {
			$this->flash->add('message', $this->article->errors->get_messages());
			$this->back();
		}
	}

	public function update() {
		$article = new Article();
		$article = $article->find($this->params['article']['id']);

		// validation
		if (!$article->validation_update($this->get_user_id())) {
			$this->flash->add('message', $article->errors->get_messages());
			$this->back();
		}

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

		// validation
		$article = $article->find($id);
		if (!$article->validation_delete($this->get_user_id())) {
			$this->flash->add('message', $article->errors->get_messages());
			$this->back();
		}

		$article->delete($id);

		$comment = new ArticleComment();
		$comment->delete('article_id = ' . $id);

		$this->redirect_to('/blog/index');
	}

	public function post_comment() {
		$comment = new ArticleComment($this->params['article_comment']);
		if ($comment->validate()) {
			$comment->user_id = $this->get_user_id();
			$comment->save();
		} else {
			$this->flash->add('message', $comment->errors->get_messages());
		}
		$this->redirect_to('/blog/view/' . $this->params['article_comment']['article_id']);
	}

	public function delete_comment($id) {
		$comment = new ArticleComment();

		// validation
		$comment = $comment->find($id);
		if (!$comment->validation_delete($this->get_user_id())) {
			$this->flash->add('message', $comment->errors->get_messages());
			$this->back();
		}

		$comment->delete($id);
		$this->back();
	}

	private function get_user_id() {
		return $this->session->get('user_id');
	}
}

