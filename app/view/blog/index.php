<ul class="thumbnails">
	<?php foreach($this->blogs as $blog) { ?>
		<li class="span12">
			<div class="thumbnail">
				<strong><a href="/blog/view/<?= $blog->id ?>"><?= h($blog->subject) ?></a><?= get_comment_count($blog->blog_comment) ?></strong>
				<p>by <?= $blog->user->nickname ?> <?= date('Y-m-d H:i', $blog->created_at) ?></p>
			</div>
		</li>
	<?php } ?>
</ul>
<?
$this->load_view('layout/_paging');
?>
<p><a href="/blog/register_form" class="btn btn-large btn-primary pull-right">새글쓰기</a></p>
<div class="clearfix"></div>
