#!/bin/bash
cd /var/www/html/chel-region-helpdesk && sudo git pull origin master
sudo docker compose exec app composer update --no-dev
sudo docker compose exec app npm run prod
sudo docker compose exec app php artisan migrate
sudo docker compose stop
cp /var/www/html/chel-region-helpdesk/.env /var/www/html/.env
sudo docker compose up -d --build
echo "yes" | sudo docker image prune -a --filter "until=24h"
mv /var/www/html/.env /var/www/html/chel-region-helpdesk/.env
echo "Приложение успешно обновлено!"
