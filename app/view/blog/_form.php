<p><input type="text" class="input-xxlarge" name="article[subject]" id="input_email" placeholder="제목" value="<?= h(get_default($this, 'article', 'subject')) ?>"></p>
<p><textarea class="input-xxlarge" rows="10" name="article[content]" id="input_contents" placeholder="내용" ><?= h(get_default($this, 'article', 'content')) ?></textarea></p>

