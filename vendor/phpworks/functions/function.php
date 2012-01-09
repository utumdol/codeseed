<?php
function parse_array_args($args = array()) {
	if (sizeof($args) == 1 && is_array($args[0])) {
		return $args[0];
	}
	return $args;
}

