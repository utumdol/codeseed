<div class="page-header">
	<h2>등록하기</h2>
</div>
<form class="form-horizontal" method="post" action="/blog/post">
	<?php $this->load_view('/blog/_form') ?>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">등록하기</button>
		<button type="reset" class="btn" onclick="history.back()">취소하기</button>
	</div>
</form>

