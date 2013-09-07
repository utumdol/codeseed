<section>
	<div class="page-header">
		<h3>
			예제 블로그
			<button class="btn btn-large btn-primary pull-right" type="button" onclick="window.location.href='/blog/register_form'">새글쓰기</button>
		</h3>
	</div>
	<!--
	<form class="" id="search_form" method="get" action="/blog/index">
		<div class="row-fluid">
			<div class="span6">
				<span class="input-prepend input-append">
					<input type="search" id="input_keyword" name="input_keyword" value="<?= h(_get('input_keyword')) ?>" placeholder="제목, 내용, 또는 글쓴이">
					<button class="btn btn-info" type="submit">검색</button>
					<button class="btn"type="button" onclick="window.location.href='/blog/index'">취소</button>
				</span>
			</div>
			<div class="span6">
				<div class="pull-right well well-small" style="margin-bottom: 0px;">총 <strong><?= $this->paging->get_total() ?></strong>건이 검색되었습니다.</div>
			</div>
		</div>
	</form>
	-->
	<div class="row-fluid">
		<div class="span8"><strong>제목</strong></div>
		<div class="span2"><strong>글쓴이</strong></div>
		<div class="span2"><strong>시간</strong></div>
	</div>
	<hr style="margin: 0 0 10px 0">
	<?php if (count($this->blogs) <= 0) { ?>
	<div class="row-fluid">
		<div class="span12 text-center">등록된 글이 없습니다.</div>
	</div>
	<hr style="margin: 0 0 10px 0">
	<?php } else { foreach($this->blogs as $blog) { ?>
	<div class="row-fluid">
		<div class="span8"><a href="/blog/view/<?= $blog->id ?>"><strong><?= h($blog->subject) ?></strong></a><?= get_comment_count($blog->blog_comment) ?></div>
		<div class="span2"><?= $blog->user->nickname ?></div>
		<div class="span2"><?= date('Y-m-d H:i:s', $blog->created_at) ?></div>
	</div>
	<hr style="margin: 0 0 10px 0">
	<?php } } ?>
	<?
	$this->load_view('layout/_paging');
	?>
</section>
