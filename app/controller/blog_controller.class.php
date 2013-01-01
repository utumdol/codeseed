<?php
class BlogController extends ApplicationController {

	public function __construct() {
		parent::__construct();
		$this->layout = 'blog';
	}

	public function before_filter() {
		if ($this->action_name == 'index' || $this->action_name == 'view') {
			return;
		}
		$this->authorize();
	}

	public function post_form() {
	}

	public function post() {
		$article = new Article(_post('article'));
		if (!$article->validate()) {
			$this->flash->add('message_error', $article->errors->get_messages());
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
		$page_size = 5;	// page size
		$offset = ($page - 1) * $page_size;

		// get id(s) in the page
		$article = new Article();
		$list = $article->select("id")->limit($offset, $page_size)->order("id DESC")->find("all");
		$ids = $article->get_ids_from_result($list);

		// get articles in the page
		$this->list = $article->join("user")->join("article_comment")->order("article.id DESC")->where($ids)->find("all");
		$this->paging = new Paging($article->count(), $page_size, '/blog/index/<page>', $page);
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
		$this->comment = $comment->join('user')->where("article_comment.article_id = ?", $id)->order('article_comment.id')->find('all');
	}

	public function update_form($id) {
		$article = new Article();
		$this->article = $article->where($id)->find();

		// validation
		if (!$this->article->validation_update($this->get_login_id())) {
			$this->flash->add('message_error', $this->article->errors->get_messages());
			$this->back();
		}
	}

	public function update() {
		$article = new Article();
		$article = $article->where(_post('article', 'id'))->find();

		// validation
		if (!$article->validation_update($this->get_login_id())) {
			$this->flash->add('message_error', $article->errors->get_messages());
			$this->back();
		}

		$article = new Article(_post('article'));
		if (!$article->validate()) {
			$this->flash->add('message_error', $article->errors->get_messages());
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
			$this->flash->add('message_error', $article->errors->get_messages());
			$this->back();
		}

		// delete article and article_comment
		$article->join('article_comment')->where($id)->delete();

		$this->redirect_to('/blog/index');
	}

	public function post_comment() {
		$comment = new ArticleComment(_post('article_comment'));
		if ($comment->validate()) {
			$comment->user_id = $this->get_login_id();
			$comment->save();
		} else {
			$this->flash->add('message_error', $comment->errors->get_messages());
		}
		$this->redirect_to('/blog/view/' . _post('article_comment', 'article_id'));
	}

	public function delete_comment($id) {
		$comment = new ArticleComment();

		// validation
		$comment = $comment->where($id)->find();
		if (!$comment->validation_delete($this->get_login_id())) {
			$this->flash->add('message_error', $comment->errors->get_messages());
			$this->back();
		}

		$comment->where($id)->delete();
		$this->back();
	}
}

