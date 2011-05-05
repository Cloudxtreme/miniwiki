<!DOCTYPE html>
<html>
<head>
	<title><?= htmlentities($website) ?> | login</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link type="text/css" rel="stylesheet" href="<?= $HOME ?>css/admin.css"  media="screen" />
</head>
<body id="login" class="admin" onload="document.forms[0].username.focus();">
	<form method="post">
		<table>
			<tr><td>Username:</td><td><input name="username" type="text" /></td></tr>
			<tr><td>Password:</td><td><input name="password" type="password" /></td></tr>
			<tr><td>         </td><td><input type="submit" value="Login" /></td></tr>
		</table>
	</form>
</body>