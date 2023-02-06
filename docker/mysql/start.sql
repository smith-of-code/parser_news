CREATE DATABASE IF NOT EXISTS `parsnews_api`;
CREATE USER if not exists 'parsnews_api_user'@'%.%.%.%' IDENTIFIED BY 'LWtdswU6dW';
GRANT ALL PRIVILEGES ON parsnews_api.* TO 'parsnews_api_user'@'%.%.%.%';
