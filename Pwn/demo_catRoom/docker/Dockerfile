FROM ubuntu:18.04

RUN sed -i 's/archive.ubuntu.com/mirrors.aliyun.com/g' /etc/apt/sources.list && sed -i 's/security.ubuntu.com/mirrors.aliyun.com/g' /etc/apt/sources.list && apt update && apt-get install -y lib32z1 xinetd && apt-get install -y openssh-server && apt-get install -y openssh-client && apt-get install -y net-tools && rm -rf /var/lib/apt/lists/ && rm -rf /root/.cache && apt-get autoclean && rm -rf /tmp/* /var/lib/apt/* /var/cache/* /var/log/*

RUN useradd -m ctf

WORKDIR /home/ctf

RUN cp -R /lib* /home/ctf && \
    cp -R /usr/lib* /home/ctf

RUN mkdir /home/ctf/dev && \
    mknod /home/ctf/dev/null c 1 3 && \
    mknod /home/ctf/dev/zero c 1 5 && \
    mknod /home/ctf/dev/random c 1 8 && \
    mknod /home/ctf/dev/urandom c 1 9 && \
    chmod 666 /home/ctf/dev/*

RUN mkdir /home/ctf/bin && \
    mkdir /home/ctf/etc && \
    cp /bin/sh /home/ctf/bin && \
    cp /bin/ls /home/ctf/bin && \
    cp /bin/cat /home/ctf/bin && \
    cp /usr/bin/whoami /home/ctf/bin/  &&\
    cp /etc/passwd /home/ctf/etc/

COPY ./start.sh /start.sh

RUN chmod +x /start.sh

COPY ./bin/flag /home/ctf/
COPY ./bin/pwn /home/ctf/

RUN chown -R root:ctf /home/ctf && \
    chmod 770 /home/ctf/pwn && \
    chmod 740 /home/ctf/flag && \
    echo "ctf:123456" | chpasswd
COPY ./config/passwd /etc/passwd

CMD ["/start.sh"]


