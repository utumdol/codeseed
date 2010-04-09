<?php
function back_with_message($message = '') {
	alert($message);
	back();
}

function back() {
	echo '"<script type="text/javascript">history.back();</script>';
}
?>
