<form class="form-horizontal" method="post" action="/blog/register">
	<?php $this->load_view('/blog/_form') ?>
	<div class="form-actions">
		<button type="submit" class="btn btn-large btn-primary">새글쓰기</button>
		<button type="reset" class="btn btn-large" onclick="history.back()">취소</button>
	</div>
</form>

