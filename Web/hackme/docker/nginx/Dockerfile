FROM centos:centos7

ENV TIME_ZOME Asia/Shanghai
ARG WJ="nginx-1.17.6"

ADD $WJ.tar.gz /tmp
RUN yum -y install net-tools
RUN yum -y install gcc gcc-c++ make openssl-devel pcre-devel zlib-devel \
        && useradd -s /sbin/nologin nginx  \    
        && mkdir -p /usr/local/nginx \
        && cd /tmp/$WJ \
        && ./configure --prefix=/usr/local/nginx --user=nginx --group=nginx --with-stream --with-http_ssl_module --with-http_stub_status_module \
        && make -j 4 \
        && make install \
        && echo "${TIME_ZOME}" > /etc/timezone \
        && ln -sf /usr/share/zoneinfo/${TIME_ZOME} /etc/localtime \
        && rm -rf /tmp/nginx* \
        && ln -s /usr/local/nginx/sbin/nginx /usr/sbin/nginx  \
        && yum install -y epel-release  \
        && rpm -Uvh http://rpms.remirepo.net/enterprise/remi-release-7.rpm \
        && yum -y install yum-utils  \
        && yum-config-manager --enable remi-php72  \
        && yum -y install php php72-php-opcache  php72-php-ldap php72-php-odbc php72-php-pear php72-php-xml php72-php-xmlrpc php72-php-soap curl curl-devel  php72-php-mbstring php72-php-mysqlnd  php72-php-fpm  php72-php-gd \
        && sed -i "s/apache/nginx/g"  /etc/opt/remi/php72/php-fpm.d/www.conf \  
        && yum clean all \
        && yum -y remove gcc gcc-c++ make \
        && chmod -R 777 /var/opt/remi/php72/lib/php/session/

COPY ./nginx.conf /usr/local/nginx/conf/
RUN echo '<?php phpinfo();?>' > /usr/local/nginx/html/info.php && \
    echo '<?php echo "404 not found";?>' > /usr/local/nginx/html/404.php

# mongodb
RUN yum install autoconf php-devel php-pear -y
COPY ./mongodb-org-3.2.repo /etc/yum.repos.d/mongodb-org-3.2.repo
RUN yum install -y mongodb-org
RUN pecl channel-update pecl.php.net
RUN pecl install mongodb

RUN echo "extension=/usr/lib64/php/modules/mongodb.so" >> /etc/opt/remi/php72/php.ini
COPY html/ /usr/local/nginx/html
RUN rm -f /usr/local/nginx/html/index.html && \
    chmod 777 /usr/local/nginx/html/ && \
    chmod 777 /usr/local/nginx/html/init.php && \
    echo "flag is in the Intranet" > /flag
WORKDIR /usr/local/nginx/
EXPOSE 80

CMD /opt/remi/php72/root/sbin/php-fpm && nginx -g "daemon off;"
