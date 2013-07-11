<div class="page-header">
	<h2>회원정보수정</h2>
</div>
<form class="form-horizontal" method="post" action="/user/update">
	<?php $this->load_view('/user/_form') ?>
	<div class="form-actions">
		<button type="submit" class="btn btn-large btn-primary">회원정보수정</button>
		<button type="reset" class="btn btn-large">취소</button>
	</div>
</form>

