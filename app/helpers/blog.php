<?php
function get_comment_count($counts, $article_id) {
	foreach($counts as $count) {
		if ($count->article_id == $article_id) {
			return ' <span id="comment_counts">[' . $count->cnt . ']</span>';
		}
	}
	return '';
}

