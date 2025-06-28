<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>{{ title in layout }}</title>
</head>
<body>
	<header>
		{{ header in layout }}
	</header>
	<main>
		{{ content in layout }}
	</main>
	<footer>
		{{ footer in layout }}
	</footer>
</body>
</html>