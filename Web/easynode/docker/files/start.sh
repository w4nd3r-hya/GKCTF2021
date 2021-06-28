#!/bin/bash

rm -rf /var/run/mysqld/mysqld.sock.lock
rm -rf /tmp/mysql.sock
usermod -d /var/lib/mysql/ mysql
ln -s /var/lib/mysql/mysql.sock /tmp/mysql.sock
chown -R mysql:mysql /var/lib/mysql

mysqld_safe &

mysql_ready() {
	mysqladmin ping --socket=/run/mysqld/mysqld.sock --user=root --password=root > /dev/null 2>&1
}

while !(mysql_ready)
do
	echo "waiting for mysql ..."
	sleep 3
done

npm install
mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root';flush privileges;" -uroot -proot

if [[ -f /db.sql ]]; then
    mysql -e "source /db.sql" -uroot -proot
    rm -f /db.sql
fi

if [[ -f /flag.sh ]]; then
	source /flag.sh
fi

cd /home/app

if [ "$APP_CMD" ];then
	su - app -c "$APP_CMD"
else
	su - app -c "node app.js"
fi
