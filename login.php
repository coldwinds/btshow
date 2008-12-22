<?php
require_once("header.php");
?>
<body>
login or <a href="register.php">register</a>:
<form action="takelogin.php" method="post">
	username: <input type="text" name="user" />
	password: <input type="password" name="passwd" />
	<input type="submit" value="login" />
</form>
</body>
