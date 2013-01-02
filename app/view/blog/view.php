<div class="page-header">
	<div class="row-fluid">
		<div class="span10">
			<h4><?= str_replace(' ', '&nbsp;', h($this->article->subject)) ?></h4>
		</div>
		<div class="span2 btn-group pagination-right" data-toggle="buttons-radio">
			<a class="btn" href="/blog/index">목록</a>
			<?php if ($this->article->is_writer(get_login_id())) { ?>
			<a class="btn" href="/blog/update_form/<?= $this->article->id ?>">수정</a>
			<a class="btn" href="/blog/delete/<?= $this->article->id ?>" id="delete_button">삭제</a>
			<?php } ?>
		</div>
	</div>
</div>
<p><?= nl2br(h($this->article->content)) ?></p>
<div class="page-header">
	<h4 class="pagination-right">
		<small>by <?= $this->article->user->nickname ?> <?= get_date($this->article->updated_at) ?></small>
	</h4>
</div>
<ul class="thumbnails">
<?php foreach ($this->comment as $comment) { ?>
		<li class="span12 thumbnail">
			<div class="row-fluid">
				<div class="span10">
					<?= nl2br(h($comment->comment)) ?>
					<?= get_delete_comment_button($comment->user->id, $comment->id) ?>
				</div>
				<small class="span2 pagination-right">
					by <?= $comment->user->nickname ?>
					<?= get_date($comment->updated_at) ?>
				</small>
			</div>
		</li>
	<?php } ?>
</ul>
<form action="/blog/post_comment" method="post" id="article_comment_form">
	<input type="hidden" name="article_comment[article_id]" value="<?= $this->article->id ?>">
	<div class="row-fluid">
		<div class="span12"><textarea class="span12" rows="5" id="comment_textarea" name="article_comment[comment]" placeholder="댓글을 입력해 주세요."></textarea></div>
	</div>
	<div class="row-fluid">
		<div class="span12"><input type="button" class="btn span12" id="submit_comment" value="댓글달기"></div>
	</div>
</form>
<script type="text/javascript">
$(function() {
	$('#delete_button').click(function() {
		return confirm('정말 삭제하시겠습니까?');
	});
	$('#comment_textarea').keyup(function(event) {
		<?php if (!is_user_logged()) { ?>
			$('#comment_textarea').blur();
			alert('로그 인이 필요합니다.');
			$('#comment_textarea').val('');
			location.href="/user/login_form?return_url=<?= _server('REQUEST_URI') ?>";
		<?php } ?>
	});
	$('#submit_comment').click(function() {
		<?php if (is_user_logged()) { ?>
			$('#article_comment_form').submit();
		<?php } else { ?>
			alert('로그 인이 필요합니다.');
			location.href="/user/login_form?return_url=<?= _server('REQUEST_URI') ?>";
		<?php } ?>
	});
});
</script>

