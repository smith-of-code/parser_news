env_file="../.env.prod"

source ${env_file}

cat ./mysql/seed.sql | docker exec -i ${APP_NAME}_mysql /usr/bin/mysql -u root --password=${DB_ROOT_PASSWORD}
