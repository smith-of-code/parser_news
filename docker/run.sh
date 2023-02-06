#!/bin/bash

if [ -n "$1" ]
then
env_file=".env.$1"
else

echo "./run.sh  no param from ( prod, example  )"
exit
fi
echo ../${env_file}

source ../${env_file}

echo "CREATE DATABASE IF NOT EXISTS \`${DB_DATABASE}\`;
CREATE USER if not exists '${DB_USERNAME}'@'%.%.%.%' IDENTIFIED BY '${DB_PASSWORD}';
GRANT ALL PRIVILEGES ON ${DB_DATABASE}.* TO '${DB_USERNAME}'@'%.%.%.%';" > ./mysql/start.sql

docker network create ${DOCKER_NETWORK_NAME}_bridge --subnet=${DOCKER_NETWORK_SUBNET}
docker-compose --env-file=../${env_file} --project-name=${APP_NAME} up -d --build

docker exec ${APP_NAME}_fpm chmod -R 0777 storage
docker exec ${APP_NAME}_fpm chmod -R 0777 public
docker exec ${APP_NAME}_fpm chmod -R 0777 bootstrap

docker exec ${APP_NAME}_fpm composer update
docker exec ${APP_NAME}_fpm cp ${env_file} .env
docker exec ${APP_NAME}_fpm php artisan key:generate
docker exec ${APP_NAME}_fpm php artisan migrate

docker exec ${APP_NAME}_fpm php artisan ide-helper:generate
docker exec ${APP_NAME}_fpm php artisan ide-helper:models --write
docker exec ${APP_NAME}_fpm php artisan ide-helper:meta
docker exec ${APP_NAME}_fpm php artisan l5-swagger:generate

docker exec ${APP_NAME}_fpm /usr/bin/supervisord
docker exec ${APP_NAME}_fpm supervisorctl update
