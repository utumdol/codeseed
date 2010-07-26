<div>
	<span><input type="text" id="subject" name="article[subject]" value="<?= h(get_value($this, array('article', 'subject'))) ?>" /></span>
</div>
<div>
	<span><textarea id="content" name="article[content]"><?= h(get_value($this, array('article', 'content'))) ?></textarea></span>
</div>

