<ul class="thumbnails">
	<?php foreach($this->articles as $article) { ?>
		<li class="span12">
			<div class="thumbnail">
				<strong><a href="/blog/view/<?= $article->id ?>"><?= h($article->subject) ?></a><?= get_comment_count($article->article_comment) ?></strong>
				<p>by <?= $article->user->nickname ?> <?= date('Y-m-d H:i', $article->created_at) ?></p>
			</div>
		</li>
	<?php } ?>
</ul>
<?
$this->load_view('layout/_paging');
?>
<p><a href="/blog/register_form" class="btn btn-large btn-primary pull-right">새글쓰기</a></p>
<div class="clearfix"></div>
