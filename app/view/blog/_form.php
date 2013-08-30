<p>
	<input type="text" class="span12" name="blog[subject]" id="input_subject" placeholder="제목*" value="<?= h(form_value($this, 'blog', 'subject')) ?>">
</p>
<p>
	<textarea class="span12" rows="10" name="blog[content]" id="input_contents" placeholder="내용*"><?= h(form_value($this, 'blog', 'content')) ?></textarea>
</p>
