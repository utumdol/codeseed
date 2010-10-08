<form class="form" action="/user/register" method="post">
<?php
$this->load_view('/user/_form');
?>
<div class="button_area">
	<span><input type="submit" value="등록하기" /></span>
	<span><input type="button" value="취소하기" onclick="javascript:history.back()" /></span>
</div>
</form>

