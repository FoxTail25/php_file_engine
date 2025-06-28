{{ title: "PHP Engine" }}
<div>
	<h2>Реализация движка</h2>
	<p>
		Реализуем движок сайта, который позволит нам сделать файл шаблона, к которому в зависимости от URL будет подключаться различный контент.<br/>
		Пусть структура нашей страницы выглядит следующим образом:
	</p>
	<code>
		<pre>
		//file: layout.php

		&lt!DOCTYPE html>
		&lthtml>
			&lthead>
				&lttitle>title&lt/title>
			&lt/head>
			&ltbody>
				&ltheader>
					header
				&lt/header>
				&ltmain>
					content
				&lt/main>
				&ltheader>
					footer
				&lt/header>
			&lt/body>
		&lt/html>
		</pre>
	</code>
	<p>
		Давайте в том месте, в которое должна происходить вставка контента вставим какую-нибудь придуманную нами команду на вставку, например вот такую: {{ content }}. Изменим шаблон нашего сайта:
	</p>
	<code>
		<pre>
		//file: layout.php

		&lt!DOCTYPE html>
		&lthtml>
			&lthead>
				&lttitle>{{ title }}&lt/title>
			&lt/head>
			&ltbody>
				&ltheader>
					{{ header }}
				&lt/header>
				&ltmain>
					{{ content }}
				&lt/main>
				&ltheader>
					{{ footer }}
				&lt/header>
			&lt/body>
		&lt/html>
		</pre>
	</code>
	<p>
		Сделаем теперь папку view, в которую будем размещать файлы контента.
	</p>
	<p>Первый файл</p>
	<code>
		<pre>
			//file: view/page1.php
			&ltdiv>page 1&lt/div>
		</pre>
	</code>
	<p>Второй файл</p>
	<code>
		<pre>
			//file: view/page2.php
			&ltdiv>page 2&lt/div>
		</pre>
	</code>
	<p>Третий файл</p>
	<code>
		<pre>
			//file: view/page3.php
			&ltdiv>page 3&lt/div>
		</pre>
	</code>
	<p>
		Давайте теперь сделаем так, чтобы по URL из адресной строки подтягивался соответствующий файл. В нашем случае по урлу /page1 будет первый файл, по урлу /page2 - второй, и по урлу /page3 - третий.<br/>
		Приступим к реализации. Для начала в файле .htaccess сделаем так, чтобы все запрошенные адреса, кроме файлов ресурсов, редиректились на страницу index.php:
	</p>
	<code>
		<pre>
			//file: .htaccess
			
			RewriteEngine On
			RewriteBase /

			RewriteCond %{REQUEST_URI} !\.(js|css|ico|jpg|png|gif)$
			RewriteRule .+ index.php
		</pre>
	</code>
	<p>
		На странице index.php получим в переменную запрошенный URL:
	</p>
	<code>
		<pre>
		//file: index.php

		&lt?php
			$url = $_SERVER['REQUEST_URI'];
		?>	
		</pre>
	</code>
	<p>
	Затем получим текст файла с шаблоном:
	</p>
	<code>
		<pre>
		//file: index.php

		&lt?php
			$layout = file_get_contents('layout.php');
		?>		
		</pre>
	</code>
	<p>
		Теперь по URL получим из папки view соответствующий файл контента:
	</p>
	<code>
		<pre>
		//file: index.php

		&lt?php
			$content = file_get_contents('view' . $url . '.php');
		?>	
		</pre>
	</code>
	<p>
	Заменим в тексте шаблона придуманную нами команду на полученный из файла контент:
	</p>
	<code>
		<pre>
		//file: index.php

		&lt?php
			$layout = str_replace('{{ content }}', $content, $layout);
		?>	
		</pre>
	</code>
	<p>
	Выведем в браузер файл шаблона с подставленным шаблоном:
	</p>
	<code>
		<pre>
		//file: index.php

		&lt?php
			echo $layout;
		?>
		</pre>
	</code>
	<p>
		Соберем все вместе и получим следующий код:
	</p>
	<code>
		<pre>
		//file:index.php

		&lt?php
			$url = $_SERVER['REQUEST_URI'];
			
			$layout  = file_get_contents('layout.php');
			$content = file_get_contents('view' . $url . '.php');
			
			$layout = str_replace('{{ content }}', $content, $layout);
			
			echo $layout;
		?>	
		</pre>
	</code>
	<p>
		Самое сложное реализовано. Если ясно как это работает, то далее всё будет намного проще. ;)
	</p>
	<h4>header & footer в движке на файлах в PHP</h4>
	<p>
		&ltheader> и &ltfooter> можно сразу прописать в файле layout.php. Но лучше прописать их в отдельных файлах. Так будет удобнее их править. И это оставляет нам возможность отображать разные header и footer на разных страницах если это нам вдруг понадобиться<br/>
		Добавим папку view 2 файла, header.php и footer.php. Теперь запишем в них разметку которая будет содержаться в header и в footer.
	</p>
	<code>
		<pre>
		//file: view/header.php

		&ltdiv>Здесь будет храниться разметка header&lt/div>


		//file: view/footer.php

		&ltdiv>Здесь будет храниться разметка footer&lt/div>
		</pre>
	</code>
	<p>
		Теперь добавим небольшие изменения в файл index.php
	</p>
	<code>
		<pre>
		//file:index.php

		&lt?php
			$url = $_SERVER['REQUEST_URI'];
			
			$layout  = file_get_contents('layout.php');
			$content = file_get_contents('view' . $url . '.php');

			$header = file_get_contents('view/header.php'); // берем из файла макет "хедера"
			$layout = str_replace('{{ header in layout }}', $header , $layout); // заменяем в макете страницы "обозначение хедера" на сам "хедер"
			$footer = file_get_contents('view/footer.php'); // берем из файла макет "футера"
			$layout = str_replace('{{ footer in layout }}', $footer , $layout);
			
			$layout = str_replace('{{ content }}', $content, $layout);
			
			echo $layout;
		?>
		</pre>
	</code>
	<p>
		<i>
			Возможно этот подход покажется излишне "усложнённым". В таком случае всегда можно отказатья от него и сразу прописать разметку header и foote в файле layout.php
		</p>
	</i>
	<h4>title в движке на файлах в PHP</h4>
	<p>
	Во всех движках, в которых контент подключается к шаблону сайта, появляется проблема тайтла. Дело в том, что страницы сайта отличаются не только контентами, но и тайтлами.<br/>
	Поэтому помимо вставки контента, нам так же нужно вставлять и title страницы.<br/>
	Есть 2 решения. Первый, хранить названия title в масиве в отдельном файле. Где ключами являются uri, а элементами сами тайтлы. Вот пример такого массива:
	</p>
	<code>
		<pre>
		//file: title.php
		&lt?php
			return [
				'/page1' => 'page 1 title',
				'/page2' => 'page 2 title',
				'/page3' => 'page 3 title',
			];
		?>
		</pre>
	</code>
	<p>
		Что бы это работало, в файле index.php надо дописать вот такой код:
	</p>
	<code>
		<pre>
		//file: index.php

		&lt?php
			$titles = require 'titles.php';
			$title = $titles[$url];
			$layout = str_replace('{{ title }}', $title, $layout);
		?>
		</pre>
	</code>

	<p>
		Есть другое решение. Хранить title странице в том же файле, в котором хранится её контент.
	</p>
	<code>
		<pre>
		//file: view/page1.php

		&#123;&#123; title: "page 1 title" &#125;&#125;
		&ltdiv>
			content 1
		&lt/div>
		</pre>
	</code>
	<p>
		Для того что бы это решение корректно работало, нужно дополнить файл index.php следующим кодом:<br/>
		(Помним что в переменную $content, мы загружаем то что должно отобразиться на странице)<br/>
		Для начала получим тайтл из текста контента:
	</p>
	<code>
		<pre>
			//file: index.php

		preg_match('#{{ title: "(.+?)" }}#', $content, $match);
		$title = $match[1]; // получаем содержимо "title" из файла страницы и записывем его в переменную $title
		</pre>
	</code>
	<p>
	Теперь в тексте контента удалим не нужную больше команду, чтобы она не попала в текст страницы:
	</p>
	<code>
		<pre>
			//file: index.php

			$content = preg_replace('#{{ title: "(.+?)" }}#', '', $content);
		</pre>
	</code>
	<p>
		Теперь в макете странцы заменим заготовку {{ title }} на тот, который должен быть. (который мы только что извлекли из контента)
	</p>
	<code>
		<pre>
			//file: index.php

			$layout = str_replace('{{ title }}', $title , $layout);
		</pre>
	</code>
	<p>
		В итоге в файле index.php у нас получается вот такой код:
	</p>
	<code>
		<pre>
		//file:index.php

		&lt?php
			$url = $_SERVER['REQUEST_URI'];
			
			$layout  = file_get_contents('layout.php');
			$content = file_get_contents('view' . $url . '.php');

			$header = file_get_contents('view/header.php'); // берем из файла макет "хедера"
			$layout = str_replace('{{ header in layout }}', $header , $layout); // заменяем в макете страницы "обозначение хедера" на сам "хедер"
			$footer = file_get_contents('view/footer.php'); // берем из файла макет "футера"
			$layout = str_replace('{{ footer in layout }}', $footer , $layout);

			preg_match('#{{ title: "(.+?)" }}#', $content, $match);
			$title = $match[1]; // получаем содержимо "title" из файла страницы и записывем его в переменную $title
			$content = preg_replace('#{{ title: "(.+?)" }}#', '', $content); // удаляем $title из содержимого страницы

			$layout = str_replace('{{ content in layout }}', $content , $layout); // записываем в макет страницы контент
			
			$layout = str_replace('{{ content }}', $content, $layout);
			
			echo $layout;
		?>
		</pre>
	</code>
	<p>
		Осталось сделать страницу <a href="make404page">404</a>
	</p>
</div>