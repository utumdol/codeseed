<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/stylesheets/blog.css" media="all" rel="stylesheet" type="text/css" />
<script src="/javascripts/jquery.js" type="text/javascript"></script>
<title>phpworks</title>
</head>
<body>
<div id="wrap">
	<div id="login">
		<?php
		if ($session->get('user_id')) {
		?>
		<?= $session->get('user_nickname'); ?>님 환영합니다.
		|
		<a href="/user/logout">로그 아웃</a>
		|
		<a href="/user/update_form">나의 정보수정</a>
		<?php
		} else {
		?>
		<a href="/user/login_form">로그 인</a>
		|
		<a href="/user/register_form">회원가입</a>
		<?php
		}
		?>
	</div>
	<div id="head">
		<span class="menu"><a href="/blog/index">예제 블로그</a></span>
	</div>
	<div id="contents">
		<div id="message">
		<?= $flash->get('message'); ?>
		</div>
		<?= $CONTENTS ?>
	</div>
	<div id="tail">Powered by PHPWorks</div>
</div>
</body>
</html>

