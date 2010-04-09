<table style="width: 600px;">
<thead>
<tr>
	<th>string_id</th>
	<th>email</th>
	<th>homepage</th>
	<th>update</th>
	<th>delete</th>
</tr>
</thead>
<tbody>
<?php
foreach($this->user_list as $user) {
?>
<tr>
	<td><a href="/user/view/<?= $user->id ?>"><?= $user->string_id ?></a></td>
	<td><?= $user->email ?></td>
	<td><?= $user->homepage ?></td>
	<td><a href="/user/update_form/<?= $user->id ?>">+</a></td>
	<td><a href="/user/remove/<?= $user->id ?>" onclick="return confirm('정말 삭제하시겠습니까?');">-</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
