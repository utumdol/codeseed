<table class="table table-hover">
	<thead>
		<tr>
			<th>글쓴이</th>
			<th>제목</th>
			<th>등록시간</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($this->list as $article) { ?>
		<tr>
			<td><?= $article->user->nickname ?></td>
			<td><a href="/blog/view/<?= $article->id ?>"><?= h($article->subject) ?></a><?= get_comment_count($article->article_comment) ?></td>
			<td><?= date('m-d H:i', $article->created_at) ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<p><button class="btn btn-block" type="button" id="btn_next_page" data-next_page="1" data-loading-text="로딩 중입니다." data-complete-text="더보기">더보기</button></p>
<p><a href="/blog/post_form" class="btn btn-primary pull-right">새글쓰기</a></p>
<div class="clearfix"></div>
