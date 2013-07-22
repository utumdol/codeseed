<?php

/**
 * 문자열에 '<br/>'을 붙여서 출력.
 */
function echobr($str = '') {
	echo $str . BR;
}

/**
 * 문자열에 '\n'을 붙여서 출력.
 */
function echonl($str = '') {
	echo $str . NL;
}

/**
 * 문자열에 '<br/>\n'을 붙여서 출력.
 */
function echobn($str = '') {
	echo $str . BR . NL;
}

/**
 * 문자열에 '<br/>\n'을 붙여서 출력.
 */
function echocl($str = '') {
	echo "<script type=\"text/javascript\">console.log(\"{$str}\")</script>";
}

/**
 * 문자열을 javascript의 alert 형식으로 출력. 
 */
function alert($message = '') {
	echo '<script type="text/javascript">alert("';
	echo $message;
	echo '");</script>';
}

