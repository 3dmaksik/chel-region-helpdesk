#!/bin/bash
NAME=$USER
su - root
mkdir -p /var/www/html
usermod -a -G www-data $NAME
chown $NAME:www-data /var/www/html
su - $NAME
cd /var/www/html/chel-region-helpdesk && git clone https://github.com/3dmaksik/chel-region-helpdesk.git
mv -f /var/www/html/chel-region-helpdesk /var/www/html
cp /var/www/html/chel-region-helpdesk/.env.docker /var/www/html/chel-region-helpdesk/.env
cp /var/www/html/chel-region-helpdesk/config/settings.php.example /var/www/html/chel-region-helpdesk/config/settings.php
mkdir /var/www/html/chel-region-helpdesk/storage/images && mkdir /var/www/html/chel-region-helpdesk/storage/avatar && mkdir /var/www/html/chel-region-helpdesk/storage/sound
su - root
docker compose up -d --build
docker compose exec app composer install --no-dev
docker compose exec app npm install
docker compose exec app npm run prod
docker compose exec app php artisan key:generate
docker compose exec app php artisan storage:link
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app chgrp -R USERNAME ./storage ./bootstrap/cache
docker compose exec app chmod -R ug+rwx ./storage ./bootstrap/cache
