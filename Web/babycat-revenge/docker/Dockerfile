FROM dasctfbase/web_tomcat8_mysql

COPY ./ROOT /usr/local/tomcat/webapps/ROOT
COPY ./server.xml /usr/local/tomcat/conf/server.xml

RUN mkdir -p /usr/local/tomcat/conf/Catalina/localhost && \
    chown -R app:app /usr/local/tomcat/conf/Catalina/localhost && \
    chmod -R 755 /usr/local/tomcat/webapps/

ENV APP_CMD="export CATALINA_HOME=/usr/local/tomcat && export CATALINA_BASE=/usr/local/tomcat && export PATH=/usr/local/tomcat/bin:/usr/local/openjdk-8/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin && JAVA_HOME=/usr/local/openjdk-8 && catalina.sh run"

COPY ./files/db.sql /db.sql
COPY ./files/readflag /readflag
COPY ./files/flag.sh /flag.sh
COPY ./files/flag.txt /flag

RUN chmod 0700 /flag
RUN chmod 0755 /readflag
RUN chmod +s /readflag
RUN chmod +x /flag.sh

RUN chown app:app /usr/local/tomcat/webapps/ROOT/* && \
    chmod 777 /usr/local/tomcat/webapps/ROOT/WEB-INF/upload && \
    chmod 777 /usr/local/tomcat/webapps/ROOT/WEB-INF/db && \
    chmod 777 /usr/local/tomcat/webapps/ROOT/WEB-INF/db/db.xml && \
    chmod 777 /usr/local/tomcat/webapps/ROOT/static && \
    chmod 777 /usr/local/tomcat/logs

EXPOSE 8080
