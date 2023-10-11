<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Zarejestruj</title>
	<link rel="stylesheet" href="style/register.css">
	<?php
	function userExists($user)
	{
		if (file_exists("users.csv")) {
			$file = fopen("users.csv", "r");
			$ret = false;
			while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
				if ($data[0] == $user) $ret = true;
			}
			fclose($file);
		} else $ret = false;
		return $ret;
	}
	if (array_key_exists("login", $_POST) && !userExists($_POST["login"])) {
		$file = fopen("users.csv", "a");
		$pass = hash('sha256', $_POST["pass"]);
		fwrite($file, $_POST["login"] . ',' . $pass . "\n");
		fclose($file);
		$lid = bin2hex(openssl_random_pseudo_bytes(32)); // Login ID
		$file = fopen("logins.csv", "a");
		fwrite($file, $lid . ',' . $_POST["login"] . "\n");
		setcookie("lid", $lid, time() + (3600 * 30), "/", $_SERVER['SERVER_NAME'], true, false);
		header('Location: index.php');
		die();
	}
	?>
</head>

<body>
	<h1>Zarejestruj się!</h1>
	<form action="register.php" method="post" name="form" id="form">
		<label for="login">Login:</label>
		<input type="text" id="login" name="login" placeholder="Login" required><br>
		<label for="pass">Hasło:</label>
		<input type="password" id="pass" name="pass" placeholder="Hasło" required><br>
		<?php
		if (array_key_exists("login", $_POST) && userExists($_POST["login"])) {
			echo "<p class='error'>Taki użytkownik już istnieje!</p>";
		}
		?>
		<input type="submit" value="Zarejestruj!" id="sub" name="sub" tabindex="-1">
		<p>Masz już konto? <a href="login.php" tabindex="-1">ZALOGUJ SIĘ</a></p>
	</form>
</body>

</html>