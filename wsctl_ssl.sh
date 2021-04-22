#!/bin/sh
# 1. chmod a+x wsctl_ssl.sh (Grant execute permission)
# 2. ./wsctl_ssl.sh start (Server running)
# 3.  ps -ef | grep server_ssl.php (Confirm execution)

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