<!DOCTYPE html>
<html>
<head>
	<title><?= htmlentities($website." | ".$page) ?></title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link type="text/css" rel="stylesheet" href="<?= $HOME ?>css/page.css"  media="screen" />
	<script type="text/javascript" src="<?= $HOME ?>js/page.js"></script>
</head>
<body id="page">
	<?= $content."\n" ?>	
</body>
</html>