<?php
function get_comment_count($comments) {
	$cnt = count($comments);
	if ($cnt > 0) {
		return ' <span id="comment_comments">[' . $cnt . ']</span>';
	}
	return '';
}

