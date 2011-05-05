<!DOCTYPE html>
<head>
	<title>404 Not Found</title>
</head>
<body>
	<h1>Not Found</h1>
	<p>The requested URL <?= htmlentities(str_replace("index.php/", "", $PATH)) ?> was not found on this server.</p>
</body>
</html>