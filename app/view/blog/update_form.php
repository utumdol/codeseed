<form class="form-horizontal" method="post" action="/blog/update">
	<input type="hidden" name="article[id]" value="<?= $this->article->id ?>" />
	<?php $this->load_view('/blog/_form') ?>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">수정하기</button>
		<button type="reset" class="btn" onclick="history.back()">취소</button>
	</div>
</form>

