<?php
function back_with_message($message = '') {
	alert($message);
	back();
}

function back() {
	echo '"<script type="text/javascript">history.back();</script>';
	throw new PassoverException();
}

function redirect_to($where) {
	echo '<meta http-equiv="refresh" content="0; URL=' . $where . '">';
	throw new PassoverException();
}

