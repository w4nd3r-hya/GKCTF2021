FROM ctfhub/base_web_nginx_mysql_php_56

COPY src /var/www/html
COPY _files/flag.sh /flag.sh
COPY _files/nginx.conf /tmp
COPY _files/ioncube.tar.gz /tmp

RUN cd /tmp \
    && tar -xvvzf ioncube.tar.gz \
    && mv ioncube/ioncube_loader_lin_5.6.so `php-config --extension-dir` \
    && rm -Rf ioncube.tar.gz ioncube \
    && docker-php-ext-enable ioncube_loader_lin_5.6


RUN sh -c 'mysqld_safe &' \
    && sleep 5s \
    && mysql -uroot -proot -e "source /var/www/html/db.sql" \
    && rm -f /var/www/html/db.sql \
    && chown -R www-data:www-data /var/www/html \
	&& mv /tmp/nginx.conf /etc/nginx/nginx.conf \
