<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Zaloguj</title>
	<link rel="stylesheet" href="style/login.css">
</head>

<body>
	<?php
	$log = false;
	if (array_key_exists("login", $_POST) && file_exists("users.csv")) {
		$file = fopen("users.csv", "r");
		$pass = hash('sha256', $_POST["pass"]);
		while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
			if ($data[0] == $_POST["login"] && $data[1] == $pass)
				$log = true;
		}
		fclose($file);
	}

	if ($log) {
		$lid = bin2hex(openssl_random_pseudo_bytes(32)); // Login ID
		$file = fopen("logins.csv", "a");
		fwrite($file, $lid . ',' . $_POST["login"] . "\n");
		setcookie("lid", $lid, time() + (3600 * 30), "/", $_SERVER['SERVER_NAME'], true, false);
		header('Location: index.php');
		die();
	}
	?>
	<h1>Zaloguj się!</h1>
	<form action="login.php" method="post" name="form" id="form">
		<label for="login">Login:</label>
		<input type="text" id="login" name="login" placeholder="Login" required><br>
		<label for="pass">Hasło:</label>
		<input type="password" id="pass" name="pass" placeholder="Hasło" required><br>
		<?php
		if (array_key_exists("login", $_POST) && !$log) {
			echo "<p class='error'>Błędne hasło/login!</p>";
		}
		?>
		<input type="submit" value="Zaloguj!" id="sub" name="sub" tabindex="-1">
		<p>Nie masz konta? <a href="register.php" tabindex="-1">ZAREJESTRUJ SIĘ</a></p>
	</form>
</body>

</html>