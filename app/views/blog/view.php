<div>
	<span class="subject"><?= $this->article->subject ?></span>
</div>
<div>
	<span class="content"><?= nl2br($this->article->content) ?></span>
</div>
<div class="menu">
	<span>[<a href="/blog/index">목록으로</a>]</span>
	<span>[<a href="/blog/update_form/<?= $this->article->id ?>">수정하기</a>]</span>
	<span>[<a href="/blog/remove/<?= $this->article->id ?>" onclick="return confirm('정말 삭제하시겠습니까?');">삭제하기</a>]</span>
</div>

