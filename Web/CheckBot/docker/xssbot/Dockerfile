FROM leonsec/xssbot:v1

WORKDIR /var/xssbot/

# 复制文件和目录
COPY ./xssbot.py /var/xssbot/

# 安装requests
RUN pip install requests

RUN sed -i 's/http:\/\/archive.ubuntu.com\/ubuntu\//http:\/\/mirrors.tuna.tsinghua.edu.cn\/ubuntu\//g' /etc/apt/sources.list && \
    sed -i '/security/d' /etc/apt/sources.list

RUN apt-get update && apt-get update --fix-missing -y
RUN apt install apache2 -y
RUN apt install php libapache2-mod-php -y

COPY ./html/ /var/www/html/
COPY ./run.sh /


# 创建文件夹
RUN mkdir /nobodys3cr3t && chown www-data:www-data /nobodys3cr3t && chmod 700 /nobodys3cr3t

# 添加权限
RUN chmod 755 -R /var/www/html/ && chown -R root:www-data /var/www/html && chmod +x /run.sh

# 运行xssbot
CMD /run.sh