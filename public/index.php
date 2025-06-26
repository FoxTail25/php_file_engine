<?php
// echo 'Hello word! (from PHP file engine)<br/>';
$url = $_SERVER['REQUEST_URI'];
// echo '$_SERVER["REQUEST_URI"] =' . $url;

$layout = file_get_contents('layout.html');
$header = file_get_contents('view/header.html');
$layout = str_replace('{{ header in layout }}', $header , $layout);
$footer = file_get_contents('view/footer.html');
$layout = str_replace('{{ footer in layout }}', $footer , $layout);

if($url != '/') {
	$content = 'view' . $url . '.php';
} else {
	$content = 'view/index.php';
	// $title = '';
}

if(file_exists($content)) {
	$content = file_get_contents($content);

} else {
	header('HTTP/1.0 404 Not Found');
	$content = file_get_contents('view/404.html');
}

preg_match('#{{ title: "(.+?)" }}#', $content, $match);
$title = $match[1];
$content = preg_replace('#{{ title: "(.+?)" }}#', '', $content);

$layout = str_replace('{{ content in layout }}', $content , $layout);
$layout = str_replace('{{ title in layout }}', $title , $layout);

echo $layout;
?>