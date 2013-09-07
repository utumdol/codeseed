<section>
	<div class="page-header">
		<div class="row-fluid">
			<div class="span10">
				<h4><?= str_replace(' ', '&nbsp;', h($this->blog->subject)) ?></h4>
			</div>
			<div class="span2 btn-group text-right" data-toggle="buttons-radio">
				<a class="btn" href="/blog/index">목록</a>
				<?php if ($this->blog->user_id == User::get_login_id()) { ?>
				<a class="btn" href="/blog/update_form/<?= $this->blog->id ?>">수정</a>
				<a class="btn" href="/blog/delete/<?= $this->blog->id ?>" id="delete_button">삭제</a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div>
		<?= nl2br(h($this->blog->content)) ?>
	</div>
	<div class="page-header">
		<h4 class="pagination-right"><small>by <?= $this->blog->user->nickname ?> at <?= date('Y-m-d H:i:s', $this->blog->updated_at) ?></small></h4>
	</div>
	<div class="comment">
		<?php foreach ($this->comment as $comment) { ?>
		<div class="row-fluid comment">
			<div class="span1"><?= $comment->user->nickname ?></div>
			<div class="span9">
				<?= nl2br(h($comment->comment)) ?>
			</div>
			<div class="span2">
				<?= date('Y-m-d H:i:s', $comment->updated_at) ?>				
				<?php if ($comment->user_id == User::get_login_id()) { ?>
					<a href="/blog/delete_comment/<?= $comment->id ?>" class="delete_button"><i class="icon-trash"></i></a>
				<?php } ?>
			</div>
		</div>
		<hr>
		<?php } ?>
	</div>
	<form action="/blog/register_comment" method="post" id="blog_comment_form">
		<input type="hidden" name="blog_comment[blog_id]" value="<?= $this->blog->id ?>">
		<div class="row-fluid">
			<div class="span12"><textarea class="span12" rows="5" id="comment_textarea" name="blog_comment[comment]" placeholder="댓글을 입력해 주세요."></textarea></div>
		</div>
		<div class="row-fluid">
			<div class="span12"><input type="button" class="btn btn-block" id="submit_comment" value="댓글달기"></div>
		</div>
	</form>
</section>
<script type="text/javascript">
$(function() {
	$('#delete_button').click(function() {
		return confirm('정말 삭제하시겠습니까?');
	});
	$('#comment_textarea').keyup(function(event) {
		<?php if (!User::is_login()) { ?>
			$('#comment_textarea').blur();
			alert('로그 인이 필요합니다.');
			$('#comment_textarea').val('');
			location.href="/user/login_form?return_url=<?= _server('REQUEST_URI') ?>";
		<?php } ?>
	});
	$('#submit_comment').click(function() {
		<?php if (User::is_login()) { ?>
			$('#blog_comment_form').submit();
		<?php } else { ?>
			alert('로그 인이 필요합니다.');
			location.href="/user/login_form?return_url=<?= _server('REQUEST_URI') ?>";
		<?php } ?>
	});
});
</script>

