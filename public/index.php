<?php
// echo 'Hello word! (from PHP file engine)<br/>';
$url = $_SERVER['REQUEST_URI']; // поучаем адрес запроса
// echo '$_SERVER["REQUEST_URI"] =' . $url;

$layout = file_get_contents('layout.html'); // берём из файла макет страницы
$header = file_get_contents('view/header.html'); // берем из файла макет "хедера"
$layout = str_replace('{{ header in layout }}', $header , $layout); // заменяем в макете страницы "обозначение хедера" на сам "хедер"
$footer = file_get_contents('view/footer.html'); // берем из файла макет "футера"
$layout = str_replace('{{ footer in layout }}', $footer , $layout); // заменяем в макете страницы "обозначение футера" на сам "футера"

if($url != '/') {
	$content = 'view' . $url . '.php';  // если адрес запроса не равен "/" то в переменую $content запичывается путь доступа к файлу.
} else {
	$content = 'view/index.php'; // если адрес запроса ревен "/" в переменную $content записывается путь к файлу с содержимым "по умолчанию"
}

if(file_exists($content)) { //Если файл существует по пути указанному в переменной $content то в переменную $content подгдружается содержимое этого файла
	$content = file_get_contents($content);
} else { // в протисном случае загружаем в переменную $cuntent содержимое 404 страницы и добавляем соответствующие ответ сервера в заголовок
	header('HTTP/1.0 404 Not Found');
	$content = file_get_contents('view/404.html');
}

preg_match('#{{ title: "(.+?)" }}#', $content, $match);
$title = $match[1]; // получаем содержимо "title" из файла страницы и записывем его в переменную $title
$content = preg_replace('#{{ title: "(.+?)" }}#', '', $content); // удаляем $title из содержимого страницы

$layout = str_replace('{{ content in layout }}', $content , $layout); // записываем в макет страницы контент
$layout = str_replace('{{ title in layout }}', $title , $layout); // записываем в макет страницы title

echo $layout; // Возвращаем страницу пользователю
?>