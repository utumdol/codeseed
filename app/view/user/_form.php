<!-- 
<div class="control-group">
	<label class="control-label" for="input_email">이메일*</label>
	<div class="controls">
		<input type="email" name="user[email]" id="input_email" placeholder="이메일" value="<?= h(get_default($this, 'user', 'email')) ?>">
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="input_nickname">별명*</label>
	<div class="controls">
		<input type="text" name="user[nickname]" id="input_nickname" placeholder="별명" value="<?= get_default($this, 'user', 'nickname') ?>">
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="input_password">비밀번호*</label>
	<div class="controls">
		<input type="password" name="user[password]" id="input_password" placeholder="비밀번호" value="<?= get_default($this, 'user', 'password') ?>">
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="input_repassword">비밀번호 확인*</label>
	<div class="controls">
		<input type="password" name="user[repassword]" id="input_repassword" placeholder="비밀번호 확인" value="<?= get_default($this, 'user', 'repassword') ?>">
	</div>
</div>
-->

<p><input type="email" name="user[email]" id="input_email" placeholder="이메일" value="<?= h(get_default($this, 'user', 'email')) ?>"></p>
<p><input type="text" name="user[nickname]" id="input_nickname" placeholder="별명" value="<?= get_default($this, 'user', 'nickname') ?>"></p>
<p><input type="password" name="user[password]" id="input_password" placeholder="비밀번호" value="<?= get_default($this, 'user', 'password') ?>"></p>
<p><input type="password" name="user[repassword]" id="input_repassword" placeholder="비밀번호 확인" value="<?= get_default($this, 'user', 'repassword') ?>"></p>
		
<script type="text/javascript">
function make_nickname() {
	$('#input_nickname').val($('#input_email').val().split('@')[0]);
}

$(function() {
	$('#input_email').keyup(function() {
		$('#input_nickname').val($('#input_email').val().split('@')[0]);
	})
	$('#input_email').blur(function() {
		$('#input_nickname').val($('#input_email').val().split('@')[0]);
	})
});
</script>

