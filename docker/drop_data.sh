read -p "Are you sure?(Yy) " -n 1 -r
echo    # (optional) move to a new line
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

read -p "Really ?????(Yy) " -n 1 -r
echo    # (optional) move to a new line
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

env_file="../.env"

source ${env_file}

tar -zcvf ../../dump_${APP_NAME}_$(date +%d-%m-%y_%H-%M).tar.gz ../../${APP_NAME}_dbdata/

#docker exec -it ${APP_NAME}_mariadb mysqldump -u root --password=${DB_ROOT_PASSWORD} --default-character-set=utf8 ${DB_DATABASE} > ../../dump_${APP_NAME}_$(date +%m-%d-%y_%H-%M).sql

rm -rf ../../${APP_NAME}_dbdata
