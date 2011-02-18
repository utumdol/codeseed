<script type="text/javascript">
$(function() {
	$('#button_cancel').click(function() {
		history.back();
	});
	$('#button_leave').click(function() {
		var result = confirm("정말 탈퇴하시겠습니까?\n등록하신 글들도 모두 함께 삭제가 됩니다.");
		if (result) {
			location.href = "/user/leave/<?= ''// $this->user->id ?>";
		}
	});
});
</script>
<form class="form" action="/user/update" method="post">
<?php
$this->load_view('/user/_form');
?>
<div class="button_area">
	<span><input type="submit" class="button" id="button_update" value="수정하기" /></span>
	<span><input type="button" class="button" id="button_cancel" value="취소하기" /></span>
	<span><input type="button" class="button" id="button_leave" value="탈퇴하기" /></span>
</div>
</form>

