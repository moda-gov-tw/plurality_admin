#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS plurality;
    GRANT ALL PRIVILEGES ON \`plurality%\`.* TO '$MYSQL_USER'@'%';
EOSQL