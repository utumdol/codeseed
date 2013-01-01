<div class="page-header">
	<a href="/blog/post_form" class="btn btn-primary pull-right">새글쓰기</a>
	<div class="clearfix"></div>
</div>
<?php foreach($this->list as $article) { ?>
<div class="row-fluid">
	<div class="span10"><strong><a href="/blog/view/<?= $article->id ?>"><?= h($article->subject) ?></a><?= get_comment_count($article->article_comment) ?></strong></div>
	<div class="span2"><small>by <?= $article->user->nickname ?> at <?= date('m-d H:i', $article->created_at) ?></small></div>
</div>
<?php } ?>
<?
$this->load_view('layout/_paging');
?>
