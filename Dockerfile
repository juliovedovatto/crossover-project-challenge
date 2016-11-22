FROM ubuntu:trusty

RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get -yq install \
        curl \
        apache2 \
        mysql-client \
        libapache2-mod-php5 \
        php5-mysql \
        php5-mcrypt \
        php5-gd \
        php5-curl \
        php-pear \
        php-apc && \
    rm -rf /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN /usr/sbin/php5enmod mcrypt
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i "s/variables_order.*/variables_order = \"EGPCS\"/g" /etc/php5/apache2/php.ini

RUN sed -i -e 's/\/var\/www\/html/\/var\/www\/html\/web/g' /etc/apache2/sites-available/000-default.conf

# ENV ALLOW_OVERRIDE **False**
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOCK_DIR=/var/lock/apache2 \
ENV APACHE_RUN_DIR=/var/run/apache2 \
ENV APACHE_PID_FILE=/var/run/apache2.pid
RUN usermod -u 1000 www-data
EXPOSE 80

RUN mkdir -p /app && rm -fr /var/www/html && ln -s /app /var/www/html
WORKDIR /app
COPY . /app

COPY .composer /root/.composer

ADD run.sh /run.sh
RUN chmod 755 /*.sh

RUN php -r "copy('https://getcomposer.org/installer', '/app/composer-setup.php');"
RUN php -r "if (hash_file('SHA384', '/app/composer-setup.php') === 'aa96f26c2b67226a324c27919f1eb05f21c248b987e6195cad9690d5c1ff713d53020a02ac8c217dbf90a7eacc9d141d') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php /app/composer-setup.php
RUN php -r "unlink('/app/composer-setup.php');"

CMD ["/run.sh"]