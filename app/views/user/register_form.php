<script type="text/javascript">
$(function() {
	$('#email').keyup(function() {
		$('#nickname').val($('#email').val().split('@')[0]);
	})
	$('#button_cancel').click(function() {
		history.back();
	});
});
</script>
<form class="form" action="/user/register" method="post">
<?php
$this->load_view('/user/_form');
?>
<div class="button_area">
	<span><input type="submit" class="button" id="button_register" value="등록하기" /></span>
	<span><input type="button" class="button" id="button_cancel" value="취소하기" /></span>
</div>
</form>

