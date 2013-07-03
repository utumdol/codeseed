<?php
function parse_request_uri($uri) {
	if(strpos($uri, Config::get('root_file')) == 1) {
		$uri = substr($uri, 1);
	} else {
		$uri = Config::get('root_file') . $uri;
	}
	return explode('/', $uri);
}

function get_files($dir) {
	$result = array();
	$files = scandir($dir);
	foreach($files as $file) {
		// skip unix hidden files started by '.'
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
	return str_replace(Config::get('root_dir') . '/', '', $path);
}

function rmrf($dir) {
	foreach (glob($dir) as $file) {
		if (is_dir($file)) {
			rmrf("$file/*");
			rmdir($file);
		} else {
			unlink($file);
		}
	}
}

/**
 * include app controller and model automatically
 */
function __autoload($class_name) {
	if (is_end_with($class_name, 'Controller')) {
		require_once(Config::get('ctrl_dir') . '/' . camel_to_under($class_name) . '.class.php');
		return;
	}
	require_once(Config::get('model_dir') . '/' . camel_to_under($class_name) . '.class.php');
}

