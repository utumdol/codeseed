<?php
class BlogController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->layout = 'blog';
	}

	public function before_filter($action = '') {
		if ($action == 'index' || $action == 'view') {
			return;
		}
		$this->authorize();
	}

	public function authorize() {
		if (is_null($this->get_login_id())) {
			$this->flash->add('message', '로그 인이 필요합니다.');
			$this->redirect_to('/user/login_form?return_url=' . Context::get()->server['REQUEST_URI']);
		}
	}

	public function post_form() {
	}

	public function post() {
		$article = new Article($this->params['article']);
		if (!$article->validate()) {
			$this->flash->add('message', $article->errors->get_messages());
			$this->back();
		}
		$article->user_id = $this->get_login_id();
		$article->save();
		$this->redirect_to('/blog/index');
	}

	/**
	 * show list
	 */
	public function index($page = '1') {
		$limit = 7;	// page size
		$offset = ($page - 1) * $limit;

		// get id(s) in the page
		$article = new Article();
		$list = $article->select("id")->limit($offset, $limit)->order("id DESC")->find("all");
		$ids = $article->get_ids_from_result($list);

		// get articles in the page
		$this->list = $article->join("user")->join("article_comment")->order("article.id DESC")->where($ids)->find("all");
		$this->paging = new Paging($article->count(), $limit, '/blog/index/<page>', $page);
	}

	/**
	 * show article
	 */
	public function view($id, $page = '1') {
		// get article
		$article = new Article();
		$this->article = $article->join('user')->where($id)->find();

		// get article comment
		$comment = new ArticleComment();
		$this->comment = $comment->join('user')->where("article_comment.article_id = ?", array($id))->order('article_comment.id')->find('all');
	}

	public function update_form($id) {
		$article = new Article();
		$this->article = $article->where($id)->find();

		// validation
		if (!$this->article->validation_update($this->get_login_id())) {
			$this->flash->add('message', $this->article->errors->get_messages());
			$this->back();
		}
	}

	public function update() {
		$article = new Article();
		$article = $article->where($this->params['article']['id'])->find();

		// validation
		if (!$article->validation_update($this->get_login_id())) {
			$this->flash->add('message', $article->errors->get_messages());
			$this->back();
		}

		$article = new Article($this->params['article']);
		if (!$article->validate()) {
			$this->flash->add('message', $article->errors->get_messages());
			$this->back();
		}

		$article->update();
		$this->redirect_to('/blog/index');
	}

	public function delete($id) {
		$article = new Article();

		// validation
		$article = $article->where($id)->find();
		if (!$article->validation_delete($this->get_login_id())) {
			$this->flash->add('message', $article->errors->get_messages());
			$this->back();
		}

		// delete article and article_comment
		$article->join('article_comment')->where($id)->delete();

		$this->redirect_to('/blog/index');
	}

	public function post_comment() {
		$comment = new ArticleComment($this->params['article_comment']);
		if ($comment->validate()) {
			$comment->user_id = $this->get_login_id();
			$comment->save();
		} else {
			$this->flash->add('message', $comment->errors->get_messages());
		}
		$this->redirect_to('/blog/view/' . $this->params['article_comment']['article_id']);
	}

	public function delete_comment($id) {
		$comment = new ArticleComment();

		// validation
		$comment = $comment->where($id)->find();
		if (!$comment->validation_delete($this->get_login_id())) {
			$this->flash->add('message', $comment->errors->get_messages());
			$this->back();
		}

		$comment->where($id)->delete();
		$this->back();
	}

	private function get_login_id() {
		return $this->session->get('user_id');
	}
}

