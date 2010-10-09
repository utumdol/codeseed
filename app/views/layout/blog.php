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
	<div id="head">예제 블로그</div>
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

