<div id="view">
	<div id="subject"><?= h($this->article->subject) ?></div>
	<div id="content"><?= nl2br(h($this->article->content)) ?></div>
</div>
<div id="comments">
	<?php
	foreach ($this->comment_list as $comment) {
	?>
	<div id="comment"><?= nl2br(h($comment->comment)) ?></div>
	<?php
	}
	?>
</div>
<form id="article_comment_form" action="/blog/post_comment" method="post">
	<input type="hidden" name="article_comment[article_id]" value="<?= $this->article->id ?>" />
	<textarea id="comment_form" name="article_comment[comment]"></textarea>
	<div class="button_area"><input type="submit" value="댓글달기" /></div>
</form>
<div class="menu_area">
	<span>[<a href="/blog/index">목록으로</a>]</span>
	<span>[<a href="/blog/update_form/<?= $this->article->id ?>">수정하기</a>]</span>
	<span>[<a href="/blog/delete/<?= $this->article->id ?>" onclick="return confirm('정말 삭제하시겠습니까?');">삭제하기</a>]</span>
</div>
