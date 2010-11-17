<div class="list_row list_top"><?= h($this->article->subject) ?></div>
<div class="list_row content"><?= nl2br(h($this->article->content)) ?></div>
<?php
foreach ($this->comment_list as $comment) {
?>
<div class="list_row comment"><?= nl2br(h($comment->comment)) ?></div>
<?php
}
?>
<form action="/blog/post_comment" method="post">
	<input type="hidden" name="article_comment[article_id]" value="<?= $this->article->id ?>" />
	<textarea class="comment_form" name="article_comment[comment]"></textarea>
	<div class="button_area"><input type="submit" class="button" value="댓글달기" /></div>
</form>
<div class="menu_area">
	<span>[<a href="/blog/index">목록으로</a>]</span>
	<span>[<a href="/blog/update_form/<?= $this->article->id ?>">수정하기</a>]</span>
	<span>[<a href="/blog/delete/<?= $this->article->id ?>" onclick="return confirm('정말 삭제하시겠습니까?');">삭제하기</a>]</span>
</div>
