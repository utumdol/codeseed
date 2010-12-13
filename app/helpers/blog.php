<?php
function get_comment_count($cnt) {
	if ($cnt > 0) {
		return ' <span id="comment_cnt">[' . $cnt . ']</span>';
	}
	return '';
}

