#!/bin/bash

echo "Configuring local Develop Environment..."

echo "Virtual host is $VIRTUAL_HOST"
echo "Container name is $CONTAINER_NAME"

echo "Configuring Nginx"
rm -rf /etc/nginx/conf.d/*
mkdir -p /www/storage/logs/docker
cp /www/docker/conf/nginx/*    /etc/nginx/conf.d/

service nginx start
service php-fpm start

while true
do
    echo "hello world" > /dev/null
    sleep 6s
done
