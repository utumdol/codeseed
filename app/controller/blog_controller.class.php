<?php
class BlogController extends ApplicationController {

	public function __construct() {
		parent::__construct();
		$this->layout = 'blog';
	}

	public function before_filter() {
		if (in_array($this->action_name, array('index', 'view'))) {
			return;
		}
		$this->authorize();
	}

	public function register_form() {
	}

	public function register() {
		$article = new Article(_post('article'));
		if (!$article->validate()) {
			$this->flash->add('message_error', $article->errors->get_messages());
			$this->back();
		}
		$article->user_id = User::get_login_id();
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
		$articles = Article::neo()->select("id")->limit($offset, $page_size)->order("id DESC")->find("all");
		$ids = extract_property($articles);

		// get articles in the page
		$this->articles = Article::neo()->join("user")->join("article_comment")->order("article.id DESC")->where($ids)->find("all");
		$this->paging = new Paging(Article::neo()->count(), $page_size, '/blog/index/<page>', $page);
	}

	/**
	 * show article
	 */
	public function view($id, $page = '1') {
		// get article
		$this->article = Article::neo()->join('user')->where($id)->find();

		// get article comment
		$this->comment = ArticleComment::neo()->join('user')->where("article_comment.article_id = ?", $id)->order('article_comment.id')->find('all');
	}

	public function update_form($id) {
		$this->article = Article::neo()->where($id)->find();
	}

	public function update() {
		$article = Article::neo()->where(_post('article', 'id'))->find();

		$article = new Article(_post('article'));
		if (!$article->validate_update()) {
			$this->flash->add('message_error', $article->errors->get_messages());
			$this->back();
		}

		$article->update();
		$this->redirect_to('/blog/index');
	}

	public function delete($id) {
		// validation
		$article = Article::neo()->where($id)->find();
		if (!$article->validate_delete()) {
			$this->flash->add('message_error', $article->errors->get_messages());
			$this->back();
		}

		// delete article and article_comment
		$article->delete();
		$this->redirect_to('/blog/index');
	}

	public function register_comment() {
		$comment = new ArticleComment(_post('article_comment'));
		if ($comment->validate()) {
			$comment->user_id = User::get_login_id();
			$comment->save();
		} else {
			$this->flash->add('message_error', $comment->errors->get_messages());
		}
		$this->redirect_to('/blog/view/' . _post('article_comment', 'article_id'));
	}

	public function delete_comment($id) {
		// validation
		$comment = ArticleComment::neo()->where($id)->find();
		if (!$comment->validate_delete()) {
			$this->flash->add('message_error', $comment->errors->get_messages());
			$this->back();
		}

		$comment->delete();
		$this->back();
	}
}

