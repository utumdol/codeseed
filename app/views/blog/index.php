<div class="list_row list_top">
	<div>제목</div>
	<div>수정일</div>
</div>
<?php
foreach($this->list as $article) {
?>
<div class="list_row">
	<div class="subject"><a href="/blog/view/<?= $article->id ?>"><?= h($article->subject) ?></a><?= get_comment_count($this->comment_counts, $article->id) ?></div>
	<div class="date"><?= date('m-d H:i', $article->updated_at) ?></div>
</div>
<?php
}
?>
<?
$this->load_view('layout/_paging');
?>
<div class="menu_area">
	<span>[<a href="/blog/index">처음으로</a>]</span><span>[<a href="/blog/post_form">등록하기</a>]</span>
</div>

