<form action="/blog/update" method="post">
<input type="hidden" name="Article[id]" value="<?= $this->article->id ?>" />
<?php
$this->load_view('/blog/_form');
?>
<div class="button_area">
	<span><input type="submit" value="수정하기" /></span>
	<span><input type="button" value="취소하기" onclick="javascript:history.back();" /></span>
</div>
</form>

