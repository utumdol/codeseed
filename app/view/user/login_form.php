<style type="text/css">
.form-signin {
	max-width: 380px;
	padding: 19px 29px 29px;
	margin: 0 auto 20px;
	background-color: #fff;
	border: 1px solid #e5e5e5;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	box-shadow: 0 1px 2px rgba(0,0,0,.05);
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
	margin-bottom: 10px;
}
.form-signin input[type="text"],
.form-signin input[type="password"] {
	font-size: 16px;
	height: auto;
	margin-bottom: 15px;
	padding: 7px 9px;
}
</style>
<form class="form-signin" action="/user/login?return_url=<?= _get('return_url') ?>" method="post">
	<h2 class="form-signin-heading">로그인</h2>
	<label for="input_user_email">이메일</label>
	<input type="email" class="input-block-level" name="user[email]" id="input_user_email" placeholder="이메일 입력" value="<?= h(form_value($this, 'user', 'email')) ?>">
	<label for="input_user_password">비밀번호</label>
	<input type="password" class="input-block-level" name="user[password]" id="input_user_password" placeholder="비밀번호 입력">
	<label class="checkbox">
		<input type="checkbox" name="remember_me" value="true" checked> 로그인 상태 유지
	</label>
	<button class="btn btn-large btn-primary" type="submit">로그인</button>
	<a class="btn btn-large" href="/user/register_form">회원가입</a>
	<a class="btn btn-large" href="/user/send_password_form">비밀번호 찾기</a>
</form>

