<div class="list_row list_top">
	<div class="form_subject">이메일</div>
	<div class="input_area"><input type="text" class="input" id="email" name="user[email]" value="<?= h(get_default($this, 'user', 'email')) ?>" /></div>
</div>
<div class="list_row">
	<div class="form_subject">별명</div>
	<div class="input_area"><input type="text" class="input" id="nickname" name="user[nickname]" value="<?= h(get_default($this, 'user', 'nickname')) ?>" /></div>
</div>
<div class="list_row">
	<div class="form_subject">비밀번호</div>
	<div class="input_area"><input type="password" class="input" id="password" name="user[password]" /></div>
</div>
<div class="list_row">
	<div class="form_subject">비밀번호 재입력</div>
	<div class="input_area"><input type="password" class="input" id="repassword" name="user[repassword]" /></div>
</div>
<script type="text/javascript">
function make_nickname() {
	$('#nickname').val($('#email').val().split('@')[0]);
}

$(function() {
	$('#email').keyup(function() {
		$('#nickname').val($('#email').val().split('@')[0]);
	})
	$('#email').blur(function() {
		$('#nickname').val($('#email').val().split('@')[0]);
	})
});
</script>

