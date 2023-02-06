env_file="../.env"

source ${env_file}

docker stop ${APP_NAME}_nginx
docker stop ${APP_NAME}_fpm
docker stop ${APP_NAME}_mariadb
docker stop ${APP_NAME}_redis

docker rm ${APP_NAME}_nginx
docker rm ${APP_NAME}_fpm
docker rm ${APP_NAME}_mariadb
docker rm ${APP_NAME}_redis

docker network rm  "${DOCKER_NETWORK_NAME}_bridge"
