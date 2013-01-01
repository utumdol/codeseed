<?php
// include system init 
require_once(dirname(__FILE__) . '/../config/init.php');

// refresh cache 
touch(Config::get('tmp_dir') . '/restart.txt');

