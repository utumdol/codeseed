<?php
/**
 * @return int
 */
function parse_migration_filename($file) {
	preg_match('/(\d+)_(.+)\.class\.php/', $file, $matches);
	return $matches;
}

