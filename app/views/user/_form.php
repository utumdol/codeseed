<div>
	<span>아이디: <input type="text" id="user_id" name="user[user_id]" value="<?= h(get_value($this, array('user', 'user_id'))) ?>" /></span>
</div>
<div>
	<span>패스워드: <input type="text" id="password" name="user[password]" value="<?= h(get_value($this, array('user', 'password'))) ?>" /></span>
</div>
<div>
	<span>별명: <input type="text" id="nickname" name="user[nickname]" value="<?= h(get_value($this, array('user', 'nickname'))) ?>" /></span>
</div>
<div>
	<span>이메일: <input type="text" id="email" name="user[email]" value="<?= h(get_value($this, array('user', 'email'))) ?>" /></span>
</div>

