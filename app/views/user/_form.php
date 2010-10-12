<div class="form_row form_top">
	<div class="form_subject">이메일</div>
	<div class="input_area"><input type="text" class="input" id="email" name="user[email]" value="<?= h(get_value($this, array('user', 'email'))) ?>" /></div>
</div>
<div class="form_row">
	<div class="form_subject">별명</div>
	<div class="input_area"><input type="text" class="input" id="nickname" name="user[nickname]" value="<?= h(get_value($this, array('user', 'nickname'))) ?>" /></div>
</div>
<div class="form_row">
	<div class="form_subject">비밀번호</div>
	<div class="input_area"><input type="password" class="input" id="password" name="user[password]" value="<?= h(get_value($this, array('user', 'password'))) ?>" /></div>
</div>
<div class="form_row">
	<div class="form_subject">비밀번호 재입력</div>
	<div class="input_area"><input type="password" class="input" id="repassword" name="user[repassword]" value="<?= h(get_value($this, array('user', 'repassword'))) ?>" /></div>
</div>

