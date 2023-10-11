<!DOCTYPE html>
<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Księga Wpisów</title>
	<link rel="stylesheet" href="style/index.css">
	<script src="http://code.jquery.com/jquery-1.4.4.js"></script>
	<script src="scripts/index.js" defer></script>
</head>

<body>
	<?php
	if (array_key_exists("add", $_POST)) {
		$file = fopen("book.csv", "a");
		fwrite($file, $_POST["user"] . ',' . str_replace("\r", '', str_replace("\n", '<br>', $_POST["entry"])) . "\n");
		fclose($file);
		header('Location: index.php');
		die();
	}
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
	?>
	<header>
		<?php
		if ($logged) {
			echo <<<EOT
			<div class="headbutts">
				<button id="add">Dodaj wpis!</button>
				<button id="logout">Wyloguj!</button>
			</div>
			<span>
				Jesteś zalogowany jako <span id="user">$user</span>
			</span>
			EOT;
		} else {
			echo <<<EOT
				<div class="headbutts">
					<button id="login">Zaloguj!</button>
					<button id="register">Zarejestruj!</button>
				</div>
			EOT;
		}
		?>
	</header>
	<h1>Wpisy</h1>
	<div id="comments">
		<?php
		$file = fopen("book.csv", "r");
		for ($i = 0; (($data = fgetcsv($file, 8000, ",")) !== FALSE) && ($logged || $i < 3); $i++) {
			if ($data[0] != "") {
				echo <<<EOT
			<fieldset class="entry">
				<legend>$data[0]</legend>
				<p>$data[1]</p>
			</fieldset>
			EOT;
			}
		}
		fclose($file);
		?>
	</div>
</body>

</html>