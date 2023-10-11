<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Zaloguj</title>
	<link rel="stylesheet" href="style/add.css">
</head>

<body>
	<h1>Dodaj wpis!</h1>
	<form action="index.php" method="post" name="form" id="form">
		<?php
		$user = "";
		if (array_key_exists("lid", $_COOKIE)) {
			$logged = true;
			$file = fopen("logins.csv", "r");
			while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
				if ($data[0] == $_COOKIE["lid"]) $user = $data[1];
			}
			fclose($file);
		} else {
			$logged = false;
			echo "<a>";
		}
		if ($logged) {
			echo <<<EOT
			<label for="user">Użytkownik:</label>
			<input type="text" id="user" required disabled value="$user">
			<input type="hidden" name="user" required value="$user"><br>
			<label for="entry">Wpis:</label>
			<textarea if="entry" name="entry" required></textarea><br>
			<input type="submit" value="Dodaj!" id="sub" name="add" tabindex="-1">
			<a href="index.php" tabindex="-1">Wróć do strony głównej</a>
			EOT;
		} else {
			echo <<<EOT
			<p class='error'>Nie jesteś zalogowany!</p>
			<a href="index.php">Wróć do strony głównej</a>
			EOT;
		}
		?>
	</form>
</body>

</html>