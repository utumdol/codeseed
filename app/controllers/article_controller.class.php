<?php
class ArticleController extends Controller {

	public function register_form() {
		$this->load_view('user/register_form');
	}

	public function register() {
		$user = new User();
		$user->validate_register();
		$user->register();
		$this->redirect_with_message('/user/index', '등록이 완료되었습니다.');
	}

	public function index($page = '1') {
		$page_size = 10;
		$user = new User();
		$this->user_list = $user->get_list('', 'id DESC', $page, $page_size);
		$this->load_view('user/list');
		$this->paging = new Paging($user->get_total(), $page_size, '/user/index/[PAGE]', $page);
		$this->load_view('layout/paging');
		$this->load_view('user/list_menu');
	}

	public function view($id, $page = '1') {
		$user = new User();
		$this->user = $user->get("id = '$id'");
		$this->load_view('user/view');
		$this->load_view('user/view_menu');
	}

	public function update_form($id) {
		$user = new User();
		$this->user = $user->get("id = '$id'");
		$this->load_view('user/register_form');
	}

	public function update() {
		$user = new User();
		$user->validate_update();
		$user->update();
		$this->redirect_with_message('/user/index', '수정이 완료되었습니다.');
	}

	public function remove($id) {
		$user = new User();
		$user->remove("id = '$id'");
		$this->redirect_with_message('/user/index', '삭제가 완료되었습니다.');
	}
}
?>
