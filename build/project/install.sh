#!/bin/bash
mkdir -p /var/www/html
chown -r www-data:www-data /var/www/html
su - www-data
cd /var/www/html
git clone https://github.com/3dmaksik/chel-region-helpdesk.git
mv -f /var/www/html/chel-region-helpdesk /var/www/html
rm var/www/html/chel-region-helpdesk
cp /var/www/html/.env.docker /var/www/html/.env
cp /var/www/html/config/settings.php.example /var/www/html/config/settings.php
mkdir /var/www/html/storage/images && mkdir /var/www/html/storage/avatar && mkdir /var/www/html/storage/sound
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
