<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>codeseed</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
body {
	padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
	padding-bottom: 40px;
}
</style>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-responsive.min.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- Le fav and touch icons -->
<!--
<link rel="shortcut icon" href="/bootstrap/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/bootstrap/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/bootstrap/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/bootstrap/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="/bootstrap/ico/apple-touch-icon-57-precomposed.png">
-->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="/">예제 블로그</a>
			<div class="nav-collapse collapse">
				<!--
				<ul class="nav">
					<li class="active"><a href="/">Home</a></li>
					<li><a href="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
				-->
				<?php
				if (User::is_login()) {
				?>
				<ul class="nav pull-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= User::get_login_user()->nickname ?>님, 반갑습니다. <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/user/update_form">내 정보 수정</a></li>
							<li><a href="/user/leave_form">회원 탈퇴</a></li>
							<li class="divider"></li>
							<li><a href="/user/logout">로그아웃</a></li>
						</ul>
					</li>
				</ul>
				<?php
				} else {
				?>
				<p class="navbar-text pull-right">
					<a href="/user/login_form" class="btn btn-mini">로그인</a>
					<a href="/user/register_form" class="btn btn-mini">회원가입</a>
				</p>
				<?php
				}
				?>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
<div class="container">
	<?php if (!is_blank($flash->get('message_success'))) { ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?= $flash->get('message_success'); ?>
		</div>
	<?php } ?>
	<?php if (!is_blank($flash->get('message_info'))) { ?>
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?= $flash->get('message_info'); ?>
		</div>
	<?php } ?>
	<?php if (!is_blank($flash->get('message_error'))) { ?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?= $flash->get('message_error'); ?>
		</div>
	<?php } ?>
	<?= $CONTENTS ?>
	<hr>
	<footer>
	<p>powered by codeseed</p>
	</footer>
</div>
<script type="text/javascript" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
</body>
</html>

