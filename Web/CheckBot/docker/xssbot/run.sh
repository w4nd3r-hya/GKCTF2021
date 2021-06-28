#!/bin/sh

service apache2 start
rm -rf /var/www/html/index.html
echo $FLAG > /flag
export FLAG=flag_not_here
FLAG=flag_not_here
while true
do
    python /var/xssbot/xssbot.py
done