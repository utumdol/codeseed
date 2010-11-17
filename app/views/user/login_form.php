<script type="text/javascript">
$(function() {
	$('#button_cancel').click(function() {
		history.back();
	});
});
</script>
<form class="form" action="/user/login" method="post">
	<div style="width: 400px; margin: auto; clear: both;">
	<div class="box" style="width: 100%;">
	<div class="list_row">
		<div class="form_subject">이메일</div>
		<div class="input_area"><input type="text" class="input" id="email" name="user[email]" value="<?= h(get_value($this, array('user', 'email'))) ?>" /></div>
	</div>
	<div class="list_row no_bottom">
		<div class="form_subject">비밀번호</div>
		<div class="input_area"><input type="password" class="input" id="password" name="user[password]" value="" /></div>
	</div>
	</div>
	</div>
<div class="button_area">
	<span><input type="submit" class="button" id="button_register" value="로그인" /></span>
	<span><input type="button" class="button" id="button_cancel" value="취소하기" /></span>
</div>
</form>

