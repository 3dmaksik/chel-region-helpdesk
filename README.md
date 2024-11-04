# Chel-region-helpdesk

![](https://img.shields.io/github/v/release/3dmaksik/chel-region-helpdesk?display_name=release&include_prereleases&sort=date) ![](https://img.shields.io/packagist/dependency-v/3dmaksik/chel-region-helpdesk/php) ![](https://img.shields.io/github/issues/3dmaksik/chel-region-helpdesk)
### О проекте

Система является простым хелпдеском для органов местного самоуправления. 
Основная цель — организация заявок от пользователей к службе айти, но может также использоваться для внутренней работы.
Возможности проекта (раздел будет дополняться по мере разработки функционала):
- Подача заявок как с регистрацией в системе, так и без неё с возможностью прикрепления скриншотов;
- Установка четырёх статусов обработки заявок;
- Возможность установки приоритета администратором для разделения заявок от более значимых к менее значимым;
- Создание категорий заявок, определение кабинетов сотрудников с целью указания точного местоположения;
- Push уведомления о новых заявках, о подходящих сроках предупреждения и просрочки заявок;
- Простая новостная лента для уведомлений пользователей.

### Требования

- Astra Linux 1.8+ или другая российская ОС, либо любая акутальная операционная система семейства Linux;
- PHP 8.1-8.3 c расширением fileinfo, 
а также со всеми стандартными расширениями, которые по умолчанию обычно включены:
[pgsql, sqlite3, gd, imagick, curl, imap, mysql, mbstring, xml, zip, bcmath, soap,
intl, readline, ldap, msgpack, igbinary, redis, pcov]
- СУБД на выбор MYSQL 8.0+/MariaDB 10.8+, PostgreSQL 14+;
- Сервер Ngnix 1.23+, Apache не рекомендуется;
- Кеш на выбор Memcashed 1.6+, Redis 7.0 или без него;
- Composer, Node, NPM, git.

### Подготовка к установке
Создать папку для работы, например`/var/www/html` и направить используемый сервер на поддиректорию`public`
Примерные настройки перенаправления для сервера ngnix. 
Изменяются в файле`/etc/nginx/nginx.conf`
````
    server {
    listen 80;
    server_name server_domain_or_IP;
    root /var/www/html/chel-region-helpdesk/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.*-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
           }
````
Если используется Apache (не рекомендуется) создаётся в корне `/var/www/html/chel-region-helpdesk/` файл `.htaccess` с примерно следующим содержанием.
````
Options +FollowSymLinks
RewriteEngine On
#RewriteCond %{HTTPS} =off
#RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [QSA,L]
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /public/$1 [L]
RewriteRule ^ index.php [L]
````
Если позволяет сервер, то безопаснее настроить через`VirtualHost`

`$ sudo nano /etc/apache2/sites-available/helpdesk.conf`
````
<VirtualHost *:80>
 ServerAdmin admin@example.com
 ServerName mydomain.com
 DocumentRoot /var/www/html/chel-region-helpdesk/public
   <Directory /var/www/html/chel-region-helpdesk>
     Options Indexes MultiViews
     AllowOverride None
     Require all granted
   </Directory>
  ErrorLog ${APACHE_LOG_DIR}/error.log
  CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
````
Дальнейший запуск:  
`$ sudo a2enmod rewrite`  
`$ sudo a2ensite helpdesk.conf`

После чего любой сервер необходимо перезапустить.

### Установка
                
1. Скопировать проект к себе на сервер в созданную ранее папку:  

`$ cd /var/www/html`
`$ git clone https://github.com/3dmaksik/chel-region-helpdesk.git`

2. Установить проект и библиотеки `$ composer install --no-dev && npm install && npm run prod`  

3. Установить права доступа на папки с тем же пользователем, что и у сервера:  

`$ sudo chgrp -R www-data ./storage ./bootstrap/cache`

`$ sudo chmod -R ug+rwx ./storage ./bootstrap/cache`

4. Создать папки и символьные ссылки для загрузки файлов:  

`$ mkdir storage/images && mkdir storage/avatar && mkdir storage/sound && mkdir storage/files`
`$ sudo ln -s ./app/public ./storage && sudo ln -s ./app/public/images ./storage/images && sudo ln -s ./app/public/avatar ./storage/avatar && sudo ln -s ./app/public/files ./storage/files && sudo ln -s ./app/public/sound ./storage/sound`

`$ sudo php artisan storage:link`  

5. Скопировать файлы настроек 

`$ cp .env.example .env && cp config/settings.php.example config/settings.php`

6. Сгенерировать ключ проекта `$ php artisan key:generate`
7. В файле `.env` заполнить все незаполненные поля.
8. Установить базу данных `$ php artisan migrate:fresh --seed`
9. В файле `config/settings.php` по желанию отредактировать настройки.
10. Настроить сокеты, планировщик, задачи, с помощью демона:  

`$ sudo apt install supervisor`  
`$ sudo npm install -g @soketi/soketi`  
`$ sudo systemctl enable supervisor`  
`$ sudo nano /etc/supervisor/conf.d/soketi.conf`  
````
[program:soketi]
command=soketi start --config=/srv/example.com/soketi.json
numprocs=1
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
stopwaitsecs=60
stopsignal=sigint
minfds=10240
stdout_logfile_maxbytes=0
stderr_logfile_maxbytes=0
user=example_user
````
`$ sudo nano /etc/supervisor/conf.d/schedule.conf`  
````
[program:schedule]
command=/usr/bin/php /srv/example.com/artisan schedule:work
numprocs=1
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
stopwaitsecs=60
stopsignal=sigint
minfds=10240
stdout_logfile_maxbytes=0
stderr_logfile_maxbytes=0
user=example_user
````
`$ sudo nano /etc/supervisor/conf.d/queue.conf`  
````
[program:queue]
command=/usr/bin/php /srv/example.com/artisan queue:work
numprocs=1
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
stopwaitsecs=60
stopsignal=sigint
minfds=10240
stdout_logfile_maxbytes=0
stderr_logfile_maxbytes=0
user=example_user
````
`$ sudo supervisorctl update`  

После чего проект готов к работе. Логин и пароль по умолчанию admin/password. По желанию его возможно изменить.
                

### Обновления
                
1. Обновления проекта `$ git pull origin master && sudo supervisorctl update`.
2. Обновления рабочих библиотек `$ composer update && npm update && npm run prod`.
3. В случае каких либо изменений файла `settings.php` необходимо из файла `settings.php.example` скопировать или изменить недостающие переменные, о чём будет сообщено в релизе.
4. В случае каких либо изменений в базе необходимо выполнить `$ php artisan migrate` .
                
### Запуск проекта в Docker
                
1.  Установить докер, если ещё не установлен [(инструкция по установке)](https://docs.docker.com/engine/install) (в таблице необходимо нажать на вашу систему)
2. Для установки проекта необходимо запустить скрипт без root (требуется wget и пользователь с id, gid 1000, обычно это созданный пользователь при установке операционной системы) `$ wget https://raw.githubusercontent.com/3dmaksik/chel-region-helpdesk/master/build/project/install.sh && sudo chmod +x install.sh && ./install.sh`. 
3. В файле `.env` укажите используемый айпи адрес или домен в строке APP_URL.
4. Для обновления проекта необходимо запустить скрипт, удалив прошлый файл, если ранее скачивался `$ wget https://raw.githubusercontent.com/3dmaksik/chel-region-helpdesk/master/build/project/update.sh && sudo chmod +x update.sh && ./update.sh`.
5. Вы также можете сохранить данные скрипты отдельно и запускать не скачивая.
6. В случае появления ошибок во время первой установки или обновления необходимо в первую очередь запустить последний выбранный скрипт повторно. Работа продолжится с места ошибки.
                
### Вопросы и предложения
По всем найденным багам, предложениям пишите [сюда](https://github.com/3dmaksik/chel-region-helpdesk/issues)

#### Лицензии используемых библиотек, связных библиотек, шрифта.
                
1. Laravel- [MIT](https://github.com/laravel/laravel#license)
2. Permission- [MIT](https://github.com/spatie/laravel-permission/blob/main/LICENSE.md)
3. Pusher- [MIT](https://github.com/pusher/pusher-http-php#license)
4. Websockets- [GNU](https://github.com/soketi/soketi/blob/1.x/LICENSE)
5. Boostrap- [MIT](https://github.com/twbs/bootstrap#copyright-and-license)
6. JQuery- [MIT](https://github.com/jquery/jquery/blob/main/LICENSE.txt)
7. RuangAdmin- [MIT](https://github.com/indrijunanda/RuangAdmin#license)
8. eStartup- [CC](https://bootstrapmade.com/license/)
9. Fancybox- [GPLv3](https://github.com/fancyapps/fancybox#license)
10. FontAwesome- [CC BY 4.0, SIL OFL 1.1, MIT](https://github.com/FortAwesome/Font-Awesome#license)
11. Select2- [MIT](https://github.com/select2/select2/blob/develop/LICENSE.md)
12. Nunito Font-  [OFL](https://github.com/googlefonts/nunito/blob/main/OFL.txt)
                
### Конец
