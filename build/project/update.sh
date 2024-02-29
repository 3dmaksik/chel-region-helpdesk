#!/bin/bash
cd /var/www/html
git pull origin master
docker compose exec app composer update --no-dev
docker compose exec app npm run prod
docker compose exec app php artisan migrate
docker compose stop
docker compose up -d --build
