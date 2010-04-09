<?php
function parse_request_uri($uri) {
	if(strpos($uri, ROOT_FILE) == 1) {
		$uri = substr($uri, 1);
	} else {
		$uri = ROOT_FILE . $uri;
	}
	return explode('/', $uri);
}

function get_files($dir) {
	$files = array();

	$dh  = opendir($dir);
	while (false !== ($filename = readdir($dh))) {
		if (strpos($filename, '.') != 0 && is_file($dir . '/' . $filename)) {
			$files[] = $dir . '/' . $filename;
		}
	} 
	return $files;
}

function require_once_all($files) {
	foreach($files as $file) {
		require_once($file);
	}
}

function require_once_dir($dir) {
	require_once_all(get_files($dir));
}

/*
function load_sys_model($modelname) {
	global $DATABASE;

	// include model file
	$model = new $modelname($DATABASE);

	return $model;
}
*/
?>
