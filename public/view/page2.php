{{ title: "page 2" }}
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
</div>