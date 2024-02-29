#!/bin/bash
mkdir -p /var/www/html
sudo usermod -a -G www-data $USER
sudo chown $USER:www-data /var/www/html
cd /var/www/html/chel-region-helpdesk && git clone https://github.com/3dmaksik/chel-region-helpdesk.git
mv -f /var/www/html/chel-region-helpdesk /var/www/html
cp /var/www/html/chel-region-helpdesk/.env.docker /var/www/html/chel-region-helpdesk/.env
cp /var/www/html/chel-region-helpdesk/config/settings.php.example /var/www/html/chel-region-helpdesk/config/settings.php
mkdir /var/www/html/chel-region-helpdesk/storage/images && mkdir /var/www/html/chel-region-helpdesk/storage/avatar && mkdir /var/www/html/chel-region-helpdesk/storage/sound
sudo docker compose up -d --build
sudo docker compose exec app composer install --no-dev
sudo docker compose exec app npm install
sudo docker compose exec app npm run prod
sudo docker compose exec app php artisan key:generate
sudo docker compose exec app php artisan storage:link
sudo docker compose exec app php artisan migrate:fresh --seed
sudo docker compose exec app chgrp -R USERNAME ./storage ./bootstrap/cache
sudo docker compose exec app chmod -R ug+rwx ./storage ./bootstrap/cache
