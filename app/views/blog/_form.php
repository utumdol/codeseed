<div class="form_row form_top">
	<div class="form_subject">제목</div>
	<div class="input_area"><input type="text" class="input" id="subject" name="article[subject]" value="<?= h(get_value($this, array('article', 'subject'))) ?>" /></div>
</div>
<div class="form_row">
	<div class="form_subject">내용</div>
	<div class="input_area"><textarea class="input" rows="20" id="content" name="article[content]"><?= h(get_value($this, array('article', 'content'))) ?></textarea></div>
</div>

