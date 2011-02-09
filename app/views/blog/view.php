<script type="text/javascript">
$(function() {
	$('.delete_button').click(function() {
		return confirm('정말 삭제하시겠습니까?');
	});
	$('#comment_textarea').keyup(function(event) {
		<?php if (!is_user_login()) { ?>
			$('#comment_textarea').blur();
			alert('로그 인이 필요합니다.');
			$('#comment_textarea').val('');
			location.href="/user/login_form?return_url=<?= $_SERVER['REQUEST_URI'] ?>";	
		<?php } ?>
	});
	$('#submit_comment').click(function() {
		<?php if (is_user_login()) { ?>
			$('#article_comment_form').submit();
		<?php } else { ?>
			alert('로그 인이 필요합니다.');
			location.href="/user/login_form?return_url=<?= $_SERVER['REQUEST_URI'] ?>";	
		<?php } ?>
	});
});
</script>
<div class="list_row list_top"><?= h($this->article->subject) ?></div>
<div class="list_row no_bottom content_meta"><?= $this->article->user->nickname ?> <?= get_date($this->article->updated_at) ?></div>
<div class="list_row content"><?= nl2br(h($this->article->content)) ?></div>
<?php foreach ($this->comment as $comment) { ?>
<div class="list_row comment">
	<div style="float:left; width: 10%; padding: 0 5px;"><?= $comment->user->nickname ?></div>
	<div style="float:left; width: 65%; border-left: solid 1px #ccc; padding: 0 5px;"><?= nl2br(h($comment->comment)) ?></div>
	<div style="float:left; padding: 0 5px;"><?= get_delete_comment_button($comment->user->id, $comment->id) ?></div>
	<div style="float:left; padding: 0 5px;"><?= get_date($comment->updated_at) ?></div>
</div>
<?php } ?>
<form action="/blog/post_comment" method="post" id="article_comment_form">
<input type="hidden" name="article_comment[article_id]" value="<?= $this->article->id ?>" />
<textarea class="comment_form input" id="comment_textarea" name="article_comment[comment]"></textarea>
<div class="button_area"><input type="button" class="button" id="submit_comment" value="댓글달기" /></div>
</form>
<div class="menu_area">
	<span>[<a href="/blog/index">목록으로</a>]</span>
	<?php if ($this->article->is_writer(get_user_id())) { ?>
	<span>[<a href="/blog/update_form/<?= $this->article->id ?>">수정하기</a>]</span>
	<span>[<a href="/blog/delete/<?= $this->article->id ?>" class="delete_button">삭제하기</a>]</span>
	<?php } ?>
</div>

