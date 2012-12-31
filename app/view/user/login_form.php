<style type="text/css">
.form-signin {
	max-width: 300px;
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
	<input type="text" class="input-block-level" name="user[email]"  placeholder="이메일 입력" value="<?= h(get_default($this, 'user', 'email')) ?>">
	<input type="password" class="input-block-level" name="user[password]" placeholder="비밀번호 입력">
	<label class="checkbox">
		<input type="checkbox" name="keep_login" value="remember-me" checked> 로그인 유지
	</label>
	<button class="btn btn-large btn-primary" type="submit">로그인</button>
</form>

