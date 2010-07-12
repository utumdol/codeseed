<?php
function alert($message = '') {
	echo '<script type="text/javascript">alert("';
	echo $message;
	echo '");</script>';
}

