<script type="text/javascript">
$(function() {
	$('#button_cancel').click(function() {
		location.href="/blog/index";
	})
});
</script>
<form id="article_form" action="/blog/update" method="post">
<input type="hidden" name="article[id]" value="<?= $this->article->id ?>" />
<?php
$this->load_view('/blog/_form');
?>
<div class="button_area">
	<span><input type="submit" id="button_update" class="button" value="수정하기" /></span>
	<span><input type="button" id="button_cancel" class="button" value="취소하기" /></span>
</div>
</form>

