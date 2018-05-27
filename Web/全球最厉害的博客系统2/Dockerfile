FROM andreisamuilik/php5.5.9-apache2.4-mysql5.5

ADD web2.tar.gz /app/
COPY sql.sql /tmp/sql.sql
COPY run.sh /run.sh
RUN a2enmod rewrite
RUN mkdir /home/yiruma
COPY clean_danger.sh /home/yiruma/clean_danger.sh

RUN chmod +x /run.sh
RUN chmod 777 /tmp/sql.sql
RUN chmod 555 /home/yiruma/clean_danger.sh

EXPOSE 80
CMD ["/run.sh"]
