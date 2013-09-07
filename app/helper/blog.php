<?php
function get_comment_count($comments) {
	$cnt = count($comments);
	if ($cnt > 0) {
		return " <span class=\"badge\">{$cnt}</span>";
	}
	return '';
}
