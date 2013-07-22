<?php

/**
 * 메일을 텍스트 형태로 발송한다.
 */
function text_mail($to, $subject, $message, $from = 'codeseed <noreply@codeseed.io>') {
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-Type: text/plain; charset=utf-8";
	$headers[] = "From: {$from}";
	$headers[] = "Reply-To: {$from}";
	$headers[] = "X-Mailer: PHP/".phpversion();

	mb_internal_encoding('UTF-8');
	mb_send_mail($to, $subject, $message, implode(NL, $headers));
}

/**
 * 메일을 HTML 형태로 발송한다.
 */
function html_mail($to, $subject, $message, $from = 'codeseed <noreply@codeseed.io>') {
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-Type: text/html; charset=utf-8";
	$headers[] = "Content-Transfer-Encoding: 8bit";
	$headers[] = "From: {$from}";
	$headers[] = "Reply-To: {$from}";
	$headers[] = "X-Mailer: PHP/".phpversion();

	mb_internal_encoding('UTF-8');
	mb_send_mail($to, $subject, $message, implode(NL, $headers));
}

