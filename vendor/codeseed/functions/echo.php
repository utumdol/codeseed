<?php
function echobr($str = '') {
	echo $str . BR;
}

function echonl($str = '') {
	echo $str . NL;
}

function echobn($str = '') {
	echo $str . BR . NL;
}

function alert($message = '') {
	echo '<script type="text/javascript">alert("';
	echo $message;
	echo '");</script>';
}
