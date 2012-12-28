<?php
function text_mail($to, $subject, $message, $from = 'Tourory <noreply@tourory.com>') {
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-Type: text/plain; charset=utf-8";
	$headers[] = "From: {$from}";
	$headers[] = "Reply-To: {$from}";
	$headers[] = "X-Mailer: PHP/".phpversion();

	mail($to, $subject, $message, implode(NL, $headers));	
}

function html_mail($to, $subject, $message, $from = 'Tourory <noreply@tourory.com>') {
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-Type: text/html; charset=utf-8";
	$headers[] = "Content-Transfer-Encoding: 8bit";
	$headers[] = "From: {$from}";
	$headers[] = "Reply-To: {$from}";
	$headers[] = "X-Mailer: PHP/".phpversion();

	mail($to, $subject, $message, implode(NL, $headers));	
}

