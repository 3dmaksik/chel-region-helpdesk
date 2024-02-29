#!/bin/bash
cd /var/www/html/chel-region-helpdesk && git pull origin master
sudo docker compose exec app composer update --no-dev
sudo docker compose exec app npm run prod
sudo docker compose exec app php artisan migrate
sudo docker compose stop
sudo docker compose up -d --build
