<div class="control-group">
	<label class="control-label" for="input_subject">제목*</label>
	<div class="controls">
		<input type="text" class="input-xxlarge" name="article[subject]" id="input_subject" placeholder="제목" value="<?= h(get_default($this, 'article', 'subject')) ?>">
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="input_contents">내용*</label>
	<div class="controls">
		<textarea class="input-xxlarge" rows="10" name="article[content]" id="input_contents" placeholder="내용"><?= h(get_default($this, 'article', 'content')) ?></textarea>
	</div>
</div>

