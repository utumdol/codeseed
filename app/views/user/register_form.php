<?php
$is_update = has_property($this, 'user');
if ($is_update) {
	$action = '/user/update';
	$button_value = '수정';
} else {
	$action = '/user/register';
	$button_value = '등록';
}
?>
<form method="POST" action="<?= $action ?>">
<input type="hidden" name="User[id]" size="50" maxlength="512" value="<?= get_property($this, array('user', 'id')) ?>" />
<table style="width: 600px;">
	<tr>
		<td style="width: 120px;">*아이디</td>
		<td style="width: 480px;">
			<?php
			if ($is_update) {
				$input_type = 'hidden';
				$value = get_property($this, array('user', 'string_id'));
			} else {
				$input_type = 'text';
				$value = '';
			}
			?>
			<input type="<?= $input_type ?>" name="User[string_id]" size="16" maxlength="16" value="<?= get_property($this, array('user', 'string_id')) ?>" /><?= $value ?>
		</td>
	</tr>
	<tr>
		<td>*비밀번호</td>
		<td><input type="password" name="User[passwd]" size="16" maxlength="16" value="" /></td>
	</tr>
	<tr>
		<td>*비밀번호 재입력</td>
		<td><input type="password" name="User[repasswd]" size="16" maxlength="16" value="" /></td>
	</tr>
	<tr>
		<td>*이메일</td>
		<td><input type="text" name="User[email]" size="50" maxlength="512" value="<?= get_property($this, array('user', 'email')) ?>" /></td>
	</tr>
	<tr>
		<td>홈페이지</td>
		<td><input type="text" name="User[homepage]" size="50" maxlength="512" value="<?= get_property($this, array('user', 'homepage')) ?>" /></td>
	</tr>
	<tr>
		<td>소개</td>
		<td><textarea name="User[intro]" cols="50" rows="5" ><?= get_property($this, array('user', 'intro')) ?></textarea></td>
	</tr>
</table>
<div style="width: 600px; text-align: center;"><input type="submit" value="<?= $button_value ?>" /></div>
</form>
