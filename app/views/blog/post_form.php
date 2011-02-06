<script type="text/javascript"> 
$(function() {
	$('#button_cancel').click(function() {
		history.back();
	});
});
</script> 
<form id="article_form" action="/blog/post" method="post">
<?php
$this->load_view('/blog/_form');
?>
<div class="button_area">
	<span><input type="submit" class="button" value="등록하기" /></span>
	<span><input type="button" class="button" value="취소하기" id="button_cancel" /></span>
</div>
</form>

