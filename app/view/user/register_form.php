<div class="page-header">
	<h2>회원가입</h2>
</div>
<form class="form-horizontal" method="post" action="/user/register">
	<?php $this->load_view('/user/_form') ?>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">회원가입</button>
		<button type="reset" class="btn">취소</button>
	</div>
</form>

