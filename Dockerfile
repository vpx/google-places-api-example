FROM ubuntu:14.04

ENV DEBIAN_FRONTEND=noninteractive \
    TERM=xterm

RUN locale-gen en_US.UTF-8
ENV LANG=en_US.UTF-8

RUN apt-get update -y \
    && apt-get install -y software-properties-common \
    && add-apt-repository ppa:ondrej/php

RUN apt-get update -y \
    && apt-get install -y \
        curl \
        git \
        make \
        php7.0 \
        php7.0-cli \
        php7.0-common \
        php7.0-curl \
        php7.0-dom \
        php7.0-fpm \
        php7.0-intl \
        php7.0-mbstring \
        php7.0-zip \
        supervisor \
    && rm -rf /var/lib/apt/lists/*

RUN mkdir /run/php/

RUN curl -Ss https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN sed -e 's~;daemonize = yes~daemonize = no~' -i /etc/php/7.0/fpm/php-fpm.conf \
    && sed -e 's~memory_limit = 128M~memory_limit = 1024M~' -i /etc/php/7.0/fpm/php.ini \
    && mkdir -p /root/.ssh \
    && echo "Host *\n\tStrictHostKeyChecking no\n" >> /root/.ssh/config

COPY ./docker/php-fpm/php.ini /etc/php/7.0/cli/conf.d/
COPY ./docker/php-fpm/php.ini /etc/php/7.0/fpm/conf.d/
COPY ./docker/php-fpm/www.conf /etc/php/7.0/fpm/pool.d/

WORKDIR /var/www
COPY . /var/www

RUN composer install --no-interaction --prefer-dist

RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www

CMD ["/usr/sbin/php-fpm7.0"]
