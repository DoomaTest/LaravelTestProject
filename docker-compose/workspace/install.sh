#!/bin/sh

cp .env.example .env

#docker-compose up -d --build
docker-compose up -d

docker-compose run --rm app php -v
docker-compose run --rm composer create-project --help
docker-compose run --rm composer install
docker-compose run --rm artisan clear:data
docker-compose run --rm artisan cache:clear
docker-compose run --rm artisan view:clear
docker-compose run --rm artisan route:clear
docker-compose run --rm artisan clear-compiled
docker-compose run --rm artisan config:cache
docker-compose run --rm artisan key:generate
docker-compose run --rm artisan storage:link
docker-compose run --rm artisan migrate --seed
#docker-compose run --rm app artisan passport:install
