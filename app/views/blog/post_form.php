<form id="article_form" action="/blog/post" method="post">
<?php
$this->load_view('/blog/_form');
?>
<div class="button_area">
	<span><input type="submit" class="button" value="등록하기" /></span>
	<span><input type="button" class="button" value="취소하기" onclick="javascript:history.back()" /></span>
</div>
</form>

