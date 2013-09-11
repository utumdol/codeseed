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
		$blog = new Blog(_post('blog'));
		$blog->trim();

		if (!$blog->validate_register()) {
			$this->flash->add('message_error', $blog->errors->get_messages());
			$this->back();
		}
		$blog->user_id = User::get_login_id();
		$blog->save();
		$this->redirect_to('/blog/index');
	}

	/**
	 * show list
	 */
	public function index($page = '1') {
		$page_size = 5;	// page size
		$offset = ($page - 1) * $page_size;

		$input_keyword = _get('input_keyword');
		$where = array();
		if (!is_blank($input_keyword)) {
			$where[] = "(blog.subject like '%" . Context::get('db')->escape_string($input_keyword) . "%'" .
					" OR blog.content like '%" . Context::get('db')->escape_string($input_keyword) . "%'" .
					" OR user.nickname like '%" . Context::get('db')->escape_string($input_keyword) . "%')";
		}
		$where = implode(' AND ', $where);

		// get id(s) in the page
		$blogs = Blog::neo()->join('user')->select('blog.id')->where($where)->limit($offset, $page_size)->find('all');
		$ids = extract_property($blogs);

		// get blogs in the page
		$this->blogs = Blog::neo()->join('user')->join('blog_comment')->order('blog.id DESC')->where($ids)->find('all');
		$this->paging = new Paging(Blog::neo()->count(), $page_size, "/blog/index/<page>?input_keyword={$input_keyword}", $page);
	}

	/**
	 * show blog
	 */
	public function view($id, $page = '1') {
		// get blog
		$this->blog = Blog::neo()->join('user')->where($id)->find();

		// get blog comment
		$this->comment = BlogComment::neo()->join('user')->where("blog_comment.blog_id = ?", $id)->order('blog_comment.id')->find('all');
	}

	public function update_form($id) {
		$this->blog = Blog::neo()->where($id)->find();
	}

	public function update() {
		$blog = new Blog(_post('blog'));
		$blog->trim();

		if (!$blog->validate_update()) {
			$this->flash->add('message_error', $blog->errors->get_messages());
			$this->back();
		}

		$blog->update();
		$this->redirect_to('/blog/index');
	}

	public function delete($id) {
		// validation
		$blog = Blog::neo()->where($id)->find();
		if (!$blog->validate_delete()) {
			$this->flash->add('message_error', $blog->errors->get_messages());
			$this->back();
		}

		// delete blog and blog_comment
		$blog->delete();
		$this->redirect_to('/blog/index');
	}

	public function register_comment() {
		$comment = new BlogComment(_post('blog_comment'));
		$comment->trim();

		if ($comment->validate_register()) {
			$comment->user_id = User::get_login_id();
			$comment->save();
		} else {
			$this->flash->add('message_error', $comment->errors->get_messages());
		}
		$this->redirect_to('/blog/view/' . _post('blog_comment', 'blog_id'));
	}

	public function delete_comment($id) {
		$comment = BlogComment::neo()->where($id)->find();

		// validation
		if (!$comment->validate_delete()) {
			$this->flash->add('message_error', $comment->errors->get_messages());
			$this->back();
		}

		$comment->delete();
		$this->back();
	}
}

