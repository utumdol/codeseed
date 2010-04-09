<table style="width: 600px;">
	<tr>
		<td style="width: 120px;">아이디</td>
		<td style="width: 480px;">
			<?= $this->user->string_id ?>
		</td>
	</tr>
	<tr>
		<td>이메일</td>
		<td><?= $this->user->email ?></td>
	</tr>
	<tr>
		<td>홈페이지</td>
		<td><?= $this->user->homepage ?></td>
	</tr>
	<tr>
		<td>소개</td>
		<td><?= nl2br($this->user->intro) ?></td>
	</tr>
</table>
