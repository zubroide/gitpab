FROM php:7.1-fpm as app

WORKDIR /var/www/html

# Install packages
RUN apt update -y \
    && apt install -y ssh git zip bzip2 wget libmcrypt-dev cron mc

# Install PHP extensions
# todo: libpng12-0 libpng12-dev libjasper-dev
RUN apt update -y \
    && apt install -y libpq-dev libpng-dev \
        libjpeg-dev libjpeg-progs libjpeg62 libfftw3-3 libfftw3-dev libwmf-dev \
        libx11-dev libxt-dev libxext-dev libxml2-dev libfreetype6-dev libexif-dev \
        libltdl3-dev graphviz pkg-config libperl-dev perl \
        libz-dev libbz2-dev libmemcached-dev libtidy-dev zlib1g-dev libicu-dev g++ \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/lib/ \
        --with-png-dir=/usr/lib/ \
        --with-jpeg-dir=/usr/lib/ \
        --with-gd \
    && docker-php-ext-install pdo_pgsql zip pcntl gd intl mcrypt \
    && pecl install -o -f redis \
    && pecl install -o -f memcached \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis memcached

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN touch /var/log/cron.log

ADD ./docker/php/entrypoint.sh /root/entrypoint.sh
ADD ./docker/wait-for-it.sh /root/wait-for-it.sh
RUN chmod 755 /root/entrypoint.sh \
    && chmod 755 /root/wait-for-it.sh

COPY ./docker/cron/crontab /etc/cron.d/app
RUN crontab /etc/cron.d/app

COPY composer.* ./
RUN php composer.phar install --no-dev --no-autoloader

# Project files
ADD . .
RUN php composer.phar dump-autoload

ENTRYPOINT ["/root/entrypoint.sh"]

# ---------------------

FROM nginx:stable-alpine
WORKDIR /var/www/html/public
COPY --from=app /var/www/html/public /var/www/html/public
