<section>
	<div class="page-header">
		<h3>비밀번호&nbsp;찾기</h3>
	</div>
	<div class="alert">
		이메일 주소를 입력하시면 임시 비밀번호가 해당 이메일 주소로 발송됩니다.<br>
		로그 인 후 임시 비밀번호를 반드시 변경해 주세요.
	</div>
	<form id="form" class="form-horizontal" method="post">
		<div class="control-group">
			<label class="control-label" for="input_email"><i class="icon-check"></i> 이메일</label>
			<div class="controls">
				<input type="email" name="user[email]" id="input_email" placeholder="이메일" value="<?= h(form_value($this, 'user', 'email')) ?>">
			</div>
		</div>
		<div class="form-actions">
			<button type="button" class="btn btn-large btn-primary" id="button_submit">임시 비밀번호 발송</button>
			<button type="button" class="btn btn-large" id="button_cancel">취소</button>
		</div>
	</form>
</section>
<script type="text/javascript">
function cancel() {
	window.history.back();
}

function submit() {
	$('#form').attr('action', '/user/send_password');
	$('#form').submit();
}

$(function() {
	$('#button_cancel').click(function() {
		cancel();
	});

	$('#button_submit').click(function() {
		submit();
	});
});
</script>

