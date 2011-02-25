<?php
function parse_request_uri($uri) {
	if(strpos($uri, Config::get()->root_file) == 1) {
		$uri = substr($uri, 1);
	} else {
		$uri = Config::get()->root_file . $uri;
	}
	return explode('/', $uri);
}

function get_files($dir) {
	$result = array();
	$files = scandir($dir);
	foreach($files as $file) {
		// skip unix hidden file which is start '.'
		if (preg_match('/^\..*$/', $file)) {
			continue;
		}
		if (is_dir($dir . '/' . $file)) {
			$result = array_merge($result, get_files($dir . '/' . $file));
		}
		if (is_file($dir . '/' . $file)) {
			$result[] = $dir . '/' . $file;
		}
	}
	return $result;
}

function require_once_all($files) {
	foreach($files as $file) {
		require_once($file);
	}
}

function require_once_dir($dir) {
	require_once_all(get_files($dir));
}

function abbr_path($path) {
	return str_replace(ROOT_DIR . '/', '', $path);
}

