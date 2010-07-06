<form action="/blog/update" method="post">
<input type="hidden" name="Article[id]" value="<?= $this->article->id ?>" />
<?php
$this->load_view('/blog/_form');
?>
<div>
	<span><input type="submit" value="submit" /></span>
</div>
</form>

