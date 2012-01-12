<div class="list_row list_top">
	<div class="input_area" style="width: 100%;"><input type="text" class="input" id="subject" name="article[subject]" value="<?= h(get_default($this, 'article', 'subject')) ?>" /></div>
</div>
<div class="list_row">
	<div class="input_area" style="width: 100%;"><textarea class="input" rows="20" id="content" name="article[content]"><?= h(get_default($this, 'article', 'content')) ?></textarea></div>
</div>

