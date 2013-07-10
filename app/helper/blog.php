<?php
function get_comment_count($comments) {
	$cnt = count($comments);
	if ($cnt > 0) {
		return ' <span id="comment_comments">[' . $cnt . ']</span>';
	}
	return '';
}

function get_date($timestamp) {
	return date('Y-m-d H:i', $timestamp);
}

function get_delete_comment_button($writer_id, $comment_id) {
	if (User::get_login_id() == $writer_id) {
		return "<a href=\"/blog/delete_comment/{$comment_id}\" class=\"delete_button\">x</a>";
	}
	return '&nbsp;';
}

