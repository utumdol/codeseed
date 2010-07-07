<div id="list">
	<div>
		<span class="subject">제목</span>
		<span class="date">생성일</span>
		<span class="date">수정일</span>
	</div>
	<?php
	foreach($this->list as $article) {
	?>
	<div>
		<span class="subject"><a href="/blog/view/<?= $article->id ?>"><?= $article->subject ?></a></span>
		<span class="date"><?= date('m-d H:i', $article->created_at) ?></span>
		<span class="date"><?= date('m-d H:i', $article->updated_at) ?></span>
	</div>
	<?php
	}
	?>
</div>
<?
$this->load_view('layout/_paging');
?>
<div class="menu_area">
	<span>[<a href="/blog/index">처음으로</a>]</span><span>[<a href="/blog/post_form">등록하기</a>]</span>
</div>

