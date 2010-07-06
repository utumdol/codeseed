<?php
function filename_to_classname($filename) {
	$result = str_replace('_', ' ', $filename);
	$result = ucwords($result);
	return str_replace(' ', '', $result);
}

function classname_to_filename($classname) {
	$arr = str_split($classname);
	$arr[0] = strtolower($arr[0]);
	$result = '';
	foreach($arr as $el) {
		if ($el >= 'A' and $el <= 'Z') {
			$result .= '_' . strtolower($el);
		} else {
			$result .= $el;
		}
	}
	return $result;
}

function classname_to_tablename($classname) {
	return classname_to_filename($classname);
}

function tablename_to_classname($tablename) {
	return filename_to_classname($tablename);
}

function filename_to_tablename($filename) {
	return $filename;
}

function tablename_to_filename($tablename) {
	return $tablename;
}

