#!/bin/sh
if [ "$1" == "start" ]; then
    php bin/server_ssl.php &
elif [ "$1" == "stop" ]; then
    pkill -9 -ef bin/server_ssl.php
elif [ "$1" == "restart" ]; then
    pkill -9 -ef bin/server_ssl.php
    php bin/server_ssl.php &
else
    echo "unknown"
fi
