# Chel-region-helpdesk

![](https://img.shields.io/github/v/release/3dmaksik/chel-region-helpdesk?display_name=release&include_prereleases&sort=date) ![](https://img.shields.io/packagist/dependency-v/laravel/laravel/php) ![](https://img.shields.io/github/issues/3dmaksik/chel-region-helpdesk)
### Требования

- Astra Linux 1.7+ или другая российская ОС, либо любая акутальная операционная система семейства Linux;
- PHP 8.1-8.2 c расширениями fileinfo, redis или memcached, 
а также со всеми стандартными расширениями, которые по умолчанию обычно включены iconv, gd, curl, mbstring, sockets;
- СУБД на выбор MYSQL 8.0+/MariaDB 10.8+, PostgreSQL 14+;
- Сервер Ngnix 1.23+, Apache не рекомендуется;
- Кеш на выбор Memcashed 1.6+, Redis 7.0 или без него;
- Composer, Node, NPM, git.

### Подготовка к установке
Создать папку для работы, например`/srv/example.com/` и направить используемый сервер на поддиректорию`public`
Примерные настройки перенаправления для сервера ngnix. 
Изменяются в файле`/etc/nginx/nginx.conf`

    server {
         listen 80;
         listen [::]:80;
         server_name example.com;
         root /srv/example.com/public;
		 
         add_header X-Frame-Options "SAMEORIGIN";
         add_header X-Content-Type-Options "nosniff";
 
          index index.php;
 
         charset utf-8;
 
         location / {
                try_files $uri $uri/ /index.php?$query_string;
          }
 
         location = /favicon.ico { access_log off; log_not_found off; }
         location = /robots.txt  { access_log off; log_not_found off; }
 
         error_page 404 /index.php;
 
         location ~ \.php$ {
                fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
                fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
                include fastcgi_params;
         }
 
         location ~ /\.(?!well-known).* {
               deny all;
         }
    }
Если используется Apache (не рекомендуется) создаётся в корне `/srv/example.com/` файл `.htaccess` с примерно следующим содержанием.

    Options +FollowSymLinks
    RewriteEngine On
    #RewriteCond %{HTTPS} =off
    #RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [QSA,L]
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ /public/$1 [L]
    RewriteRule ^ index.php [L]

Если позволяет сервер, то безопаснее настроить через`VirtualHost`

`$ sudo nano /etc/apache2/sites-available/helpdesk.conf`

    <VirtualHost *:80>
        ServerAdmin admin@example.com
        ServerName mydomain.com
        DocumentRoot /var/www/html/laravel/public
        <Directory /var/www/html/laravel>
        Options Indexes MultiViews
        AllowOverride None
        Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
Дальнейший запуск:
`$ sudo a2enmod rewrite`
`$ sudo a2ensite helpdesk.conf`

После чего любой сервер необходимо перезапустить.

### Установка
                
1. Скопировать проект к себе на сервер в созданную ранее папку:
`$ git clone https://github.com/3dmaksik/chel-region-helpdesk.git`

2. Установить проект и библиотеки
`$ composer install`
Если проект будет самостоятельно дорабатываться, то необходимо установить дополнительно билиблиотеки разработки командой `$ npm run prod`, остальным этот шаг можно пропустить.

3. Установить права и ссылки для следующих папок:
`$ sudo chmod -R 777 ./storage`
`$ sudo chmod -R 777 ./bootstrap/cache/`
`$ sudo ln -s /sitepath/storage/app/public /sitepath/public/storage`
4. Создать файл настроек или скопировать его командой `$ cp .env.example .env`
5. Сгенерировать ключ проекта командой `$ php artisan key:generate`

6. В файле `.env` заполнить все незаполненные поля.
7. Установить базу данных `$ php artisan migrate:fresh --seed`
8. Запустить сокеты `$ php artisan websockets:serve` 
Чтобы не запускать сокеты каждый раз вы можете настроить демон
`$ apt install supervisor`
`$ systemctl enable supervisord`
`$ nano /etc/supervisor/conf.d/websockets.conf`


	[program:websockets]
	command=/path/php /sitepath/artisan websockets:serve
	numprocs=1
	autostart=true
	autorestart=true
	user=laravel-echo

`$ supervisorctl update`
`$ supervisorctl start websockets`

После чего проект готов к работе. 
PS. Рады всем, кто сможет предоставить скрипт автоматического развёртывания.
                

### Обновления
                
1. Обновления проекта и рабочих библиотек `$ composer update`, библиотек разработки `$ npm update` соответственно.
2. Если самостоятельно изменили файл `config/settings.php` и не хотите, чтобы в результате обновлений он изменялся обратно необходимо игнорировать 
`$ git update-index --assume-unchanged config/settings.php`
                

### Вопросы и предложения
По всем найденным багам, предложениям пишите [сюда](https://github.com/3dmaksik/chel-region-helpdesk/issues)

#### Лицензии используемых библиотек, связных библиотек, шрифта и другой текст, который никто не читает.
                
1. Laravel- [MIT](https://github.com/laravel/laravel#license)
2. Cache- [Apache 2.0](https://github.com/renoki-co/laravel-eloquent-query-cache/blob/master/LICENSE)
3. Permission- [MIT](https://github.com/spatie/laravel-permission/blob/main/LICENSE.md)
4. Pusher- [MIT](https://github.com/pusher/pusher-http-php#license)
5. Websockets- [MIT](https://github.com/beyondcode/laravel-websockets/blob/master/LICENSE)
6. Boostrap- [MIT](https://github.com/twbs/bootstrap#copyright-and-license)
7. JQuery- [MIT](https://github.com/jquery/jquery/blob/main/LICENSE.txt)
8. RuangAdmin- [MIT](https://github.com/indrijunanda/RuangAdmin#license)
9. eStartup- [CC](https://bootstrapmade.com/license/)
10. Fancybox- [GPLv3](https://github.com/fancyapps/fancybox#license)
11. FontAwesome- [CC BY 4.0, SIL OFL 1.1, MIT](https://github.com/FortAwesome/Font-Awesome#license)
12. Select2- [MIT](https://github.com/select2/select2/blob/develop/LICENSE.md)
13. Nunito Font-  [OFL](https://github.com/googlefonts/nunito/blob/main/OFL.txt)
                
### Конец
