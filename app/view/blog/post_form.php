<!--
<div class="page-header">
	<h2>새글쓰기</h2>
</div>
-->
<form class="form-horizontal" method="post" action="/blog/post">
	<?php $this->load_view('/blog/_form') ?>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">새글쓰기</button>
		<button type="reset" class="btn" onclick="history.back()">취소</button>
	</div>
</form>

