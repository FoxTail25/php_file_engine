{{ title: "make 404 page" }}
<div>
	<h3 class="text-center">Создание страницы 404</h3>
	<p>
		Самый простой способ, вернуть страницу 404 это проанализировать URI и проверить есть ли у нас в паке view файл с подобным названием. Если он есть, то отдаём его содержимое, если такого файла нет, то отдаём страницу 404.<br/>
		Для начала создадим в папки view файл 404.php, в котором мы будем хранить title и content разметку страницы 404.
	</p>
	<code>
		<pre>
			//file: view/404.php

			&#123;&#123; title: "404" &#125;&#125;
			&ltdiv>
				&ltp style="text-align: left;">
					Эту страницу ещё не написали....
				&lt/p>
				&ltp style="text-align: right;">
					&lta href="/">...вернуться на главную&lt/a>
				&lt/p>
			
		</pre>
	</code>
	<p>
		Далее мы дополняем файл index.php следующим кодом:
	</p>
	<code>
		<pre>
		if($url != '/') { // если адрес запроса не равен "/" то в переменую $content запиcывается путь доступа к файлу.
			$content = 'view' . $url . '.php'; 
		} else { // если адрес запроса ревен "/" в переменную $content записывается путь к файлу с содержимым "по умолчанию"
			$content = 'view/home.php';
		}
		</pre>
	</code>
	<p>
		А теперь делаем проверку на наличие файла в папке view и если он есть, то загружаем его содержимое в переменную $content. Если же его нет, то загружаем в переменную содержимое файла 404.php и добавляем нужный код в заголовок.
	</p>
	<code>
		<pre>
		if(file_exists($content)) { //Если файл существует по пути указанному в переменной $content то в переменную $content подгдружается содержимое этого файла
			$content = file_get_contents($content);
		} else { // в протисном случае загружаем в переменную $cuntent содержимое 404 страницы и добавляем соответствующие ответ сервера в заголовок
			header('HTTP/1.0 404 Not Found');
			$content = file_get_contents('view/404.php');
		}
		</pre>
	</code>
	<p>
		В итоге, полное содержимое файла index.php будет выглядеть вот так:
	</p>
	<code>
		<pre>
		//file: index.php

		&lt?php
			// echo 'Hello word! (from PHP file engine)<br/>';
			$url = $_SERVER['REQUEST_URI']; // поучаем адрес запроса
			// echo '$_SERVER["REQUEST_URI"] =' . $url;

			$layout = file_get_contents('layout.php'); // берём из файла макет страницы
			$header = file_get_contents('view/header.html'); // берем из файла макет "хедера"
			$layout = str_replace('{{ header in layout }}', $header , $layout); // заменяем в макете страницы "обозначение хедера" на сам "хедер"
			$footer = file_get_contents('view/footer.html'); // берем из файла макет "футера"
			$layout = str_replace('{{ footer in layout }}', $footer , $layout); // заменяем в макете страницы "обозначение футера" на сам "футера"

			if($url != '/') { // если адрес запроса не равен "/" то в переменую $content запичывается путь доступа к файлу.
				$content = 'view' . $url . '.php'; 
			} else { // если адрес запроса ревен "/" в переменную $content записывается путь к файлу с содержимым "по умолчанию"
				$content = 'view/index.php';
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
		</pre>
	</code>
</div>