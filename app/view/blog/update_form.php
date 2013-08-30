<form class="form-horizontal" method="post" action="/blog/update">
	<input type="hidden" name="blog[id]" value="<?= $this->blog->id ?>" />
	<?php $this->load_view('/blog/_form') ?>
	<div class="form-actions">
		<button type="submit" class="btn btn-large btn-primary">수정하기</button>
		<button type="reset" class="btn btn-large" onclick="history.back()">취소</button>
	</div>
</form>

