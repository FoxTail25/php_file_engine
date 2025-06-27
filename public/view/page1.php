{{ title: ".htaccess" }}
<div>
	<h2>Использование htaccess в движке PHP</h2>
	<p class="bg-warning p-2">
	Важно! Не открывайте .htaccess с помощью «Блокнота», если используете Windows. Так в файл запишутся дополнительные символы, которые сервер Apache может обработать неправильно. Лучше всего редактировать файл через консоль или Notepad++.
	</p>
	<p>
	Для того, чтобы сделать движок сайта, для начала нужно сделать так, чтобы запрос любого URL сайта обрабатывался одним файлом PHP.<br/>
	Это делается с помощью специального файла .htaccess. Давайте создадим этот файл и включим его, написав в начале его текста следующие строки:
	</p>
	<code>
		<pre>
		//file: .htaccess

		RewriteEngine On
		RewriteBase /
		</pre>
	</code>
	<p>
	После этого мы можем указывать, какой файл должен обрабатывать запрощенный URL. Это делается с помощью команды RewriteRule.<br/>
	Посмотрим на работу этой команды на практике. К примеру, сделаем так, чтобы адрес mysite.ru/test был обработан файлом index.php<br/>
	Итог:
	</p>
	<code>
		<pre>
		//file: .htaccess

		RewriteEngine On
		RewriteBase /
		RewriteRule /test index.php
		</pre>
	</code>
	<p>
	Первым параметром команда RewriteRule на самом деле принимает регулярное выражение. Давайте с его помощью сделаем так, чтобы все URL обрабатывались файлом index.php<br/>
	Итог:
	</p>
	<code>
		<pre>
		//file: .htaccess

		RewriteEngine On
		RewriteBase /
		RewriteRule .+ index.php
		</pre>
	</code>
	<p>
	Однако, часть адресов все-таки не должны перенаправляться. Это адреса, которые ведут к файлам ресурсов: к CSS, JavaScript, картинкам и так далее.<br/>
	Отменим их перенаправление с помощью команды RewriteCond<br/>
	Итог:
	</p>
	<code>
		<pre>
		//file: .htaccess

		RewriteEngine On
		RewriteBase /
		RewriteCond %{REQUEST_URI} !\.(js|css|ico|jpg|png)$
		RewriteRule .+ index.php
		</pre>
	</code>
	<p>
	На странице index.php мы можем получить запрошенный URL с помощью суперглобального массива $_SERVER:
	</p>
	<code>
		<pre>
		//file: index.php

		&lt?php
			$url = $_SERVER['REQUEST_URI'];
		?>
		</pre>
	</code>
	<br/>
	Рекомендую прочитать <a href="https://skillbox.ru/media/code/chto-takoe-htaccess-i-kak-ego-nastroit/">Более подробные объяснения о файле .htaccess</a>
</div>