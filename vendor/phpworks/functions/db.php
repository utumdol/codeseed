<?php
function quotes_to_string($type, $value) {
	if (stristr($type, 'char') || stristr($type, 'text')) {
		return '\'' . $value . '\'';
	}
	return $value;
}

