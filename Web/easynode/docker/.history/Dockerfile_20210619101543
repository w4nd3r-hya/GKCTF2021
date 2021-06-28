FROM node:12-buster
COPY files /tmp/files/
RUN mv /tmp/files/flag.sh / && \
    mv /tmp/files/start.sh / && \
    mv /tmp/files/db.sql / && \
    chmod +x /flag.sh /start.sh && \
    useradd app && \
    mkdir -p /home/app && \
    chown -R root:root /home/app && \
    chmod -R 755 /home/app && \
    mv /tmp/files/src/* /home/app &&  \
    npm config set registry https://registry.npm.taobao.org && \
    sed -i 's/deb.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list && \
	sed -i '/security/d' /etc/apt/sources.list && \
    apt-get update && \
    cd /home/app && \
    npm install  && \
    cd / && \
    apt-get install libaio1 libnuma1 psmisc libmecab2 -y && \
    DEBIAN_FRONTEND=noninteractive dpkg -i /tmp/files/mysql-common_5.7.29-1debian10_amd64.deb && \
    DEBIAN_FRONTEND=noninteractive dpkg -i /tmp/files/mysql-community-client_5.7.29-1debian10_amd64.deb && \
    DEBIAN_FRONTEND=noninteractive dpkg -i /tmp/files/mysql-client_5.7.29-1debian10_amd64.deb && \
    DEBIAN_FRONTEND=noninteractive dpkg -i /tmp/files/mysql-community-server_5.7.29-1debian10_amd64.deb && \
    DEBIAN_FRONTEND=noninteractive dpkg -i /tmp/files/mysql-server_5.7.29-1debian10_amd64.deb && \
    rm -rf /tmp/files && \
    rm -rf /var/lib/apt/lists/*
WORKDIR /home/app
CMD /start.sh
