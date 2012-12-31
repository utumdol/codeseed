<table class="table table-hover">
	<tbody>
		<?php foreach($this->list as $article) { ?>
		<tr>
			<td>
				<strong><a href="/blog/view/<?= $article->id ?>"><?= h($article->subject) ?></a><?= get_comment_count($article->article_comment) ?></strong><br/>
				<small>by <?= $article->user->nickname ?> at <?= date('m-d H:i', $article->created_at) ?></small>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<p><a href="/blog/post_form" class="btn btn-primary pull-right">새글쓰기</a></p>
<div class="clearfix"></div>
