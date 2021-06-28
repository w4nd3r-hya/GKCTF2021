FROM centos:centos7
RUN echo 123
ARG JDK_PKG
ARG WEBLOGIC_JAR

RUN groupadd -g 1000 oinstall && useradd -u 1100 -g oinstall oracle
RUN mkdir -p /install && mkdir -p /scripts
ENV JDK_PKG=$JDK_PKG
ENV WEBLOGIC_JAR=$WEBLOGIC_JAR


COPY scripts/jdk_install.sh /scripts/jdk_install.sh 
COPY scripts/jdk_bin_install.sh /scripts/jdk_bin_install.sh 
COPY scripts/weblogic_install12c.sh /scripts/weblogic_install12c.sh
COPY scripts/create_domain12c.sh /scripts/create_domain12c.sh
COPY jdks/$JDK_PKG .
COPY weblogics/$WEBLOGIC_JAR .

# 判断jdk是包（bin/tar.gz）weblogic包（11g/12c）载入对应脚本
RUN if [ $JDK_PKG == *.bin ] ; then echo ****载入JDK bin安装脚本**** && cp /scripts/jdk_bin_install.sh /scripts/jdk_install.sh ; else echo ****载入JDK tar.gz安装脚本**** ; fi
RUN echo ****载入12c安装脚本**** && cp /scripts/weblogic_install12c.sh /scripts/weblogic_install.sh && cp /scripts/create_domain12c.sh /scripts/create_domain.sh

RUN chmod +x /scripts/jdk_install.sh
RUN chmod +x /scripts/weblogic_install.sh
RUN chmod +x /scripts/create_domain.sh
# 安装JDK
RUN /scripts/jdk_install.sh
# 安装weblogic
RUN /scripts/weblogic_install.sh
# 创建Weblogic Domain
RUN /scripts/create_domain.sh

RUN rm -rf /install
RUN rm -f /$JDK_PKG
RUN rm -f /create_domain_7001.py

COPY ./files/readflag /readflag
COPY ./files/flag.sh /flag.sh
COPY ./files/flag.txt /flag

RUN chmod 0700 /flag
RUN chmod 0755 /readflag
RUN chmod +s /readflag
RUN chmod +x /flag.sh

CMD ["/u01/app/oracle/Domains/ExampleSilentWTDomain/bin/startWebLogic.sh"]
EXPOSE 7001