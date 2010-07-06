<div>
	<span>subject</span>
	<span><input type="text" name="Article[subject]" value="<?= get_value($this, array('article', 'subject')) ?>" /></span>
</div>
<div>
	<span>content</span>
	<span><textarea name="Article[content]"><?= get_value($this, array('article', 'content')) ?></textarea></span>
</div>

