<script type="text/javascript">
$(function() {
	$('#delete_article').click(function() {
		return confirm('정말 삭제하시겠습니까?');
	});
	$('#submit_comment').click(function() {
		<?php if ($this->session->get('user_id')) { ?>
			$('#article_comment_form').submit();
		<?php } else { ?>
			alert('로그 인이 필요합니다.');
			location.href="/user/login_form?return_url=" + location.href;	
		<?php } ?>
	});
});
</script>
<div class="list_row list_top"><?= h($this->article->subject) ?></div>
<div class="list_row no_bottom content_meta"><?= $this->article->user->nickname ?> <?= date('Y-m-d H:i:s', $this->article->updated_at) ?></div>
<div class="list_row content"><?= nl2br(h($this->article->content)) ?></div>
<?php foreach ($this->article->article_comment as $comment) { ?>
<div class="comment" style="text-align: right;"><?= $this->users[$comment->user_id]->nickname ?> <?= date('Y-m-d H:i:s', $comment->updated_at) ?> [삭제하기]</div>
<div class="list_row comment"><?= nl2br(h($comment->comment)) ?></div>
<?php } ?>
<form action="/blog/post_comment" method="post" id="article_comment_form">
<input type="hidden" name="article_comment[article_id]" value="<?= $this->article->id ?>" />
<textarea class="comment_form input" id="comment_textarea" name="article_comment[comment]"></textarea>
<div class="button_area"><input type="button" class="button" id="submit_comment" value="댓글달기" /></div>
</form>
<div class="menu_area">
	<span>[<a href="/blog/index">목록으로</a>]</span>
	<span>[<a href="/blog/update_form/<?= $this->article->id ?>">수정하기</a>]</span>
	<span>[<a href="/blog/delete/<?= $this->article->id ?>" id="delete_article">삭제하기</a>]</span>
</div>
