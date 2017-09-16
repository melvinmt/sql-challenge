FROM mysql:5.6

ENV MYSQL_DATABASE=challenge
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_USER=challenge
ENV MYSQL_PASSWORD=challenge

ADD ./dump.sql /docker-entrypoint-initdb.d/dump.sql
ADD ./my.cnf /etc/mysql/my.cnf 
