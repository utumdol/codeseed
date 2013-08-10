<p>
	<input type="text" class="span12" name="article[subject]" id="input_subject" placeholder="제목*" value="<?= h(form_value($this, 'article', 'subject')) ?>">
</p>
<p>
	<textarea class="span12" rows="10" name="article[content]" id="input_contents" placeholder="내용*"><?= h(form_value($this, 'article', 'content')) ?></textarea>
</p>
