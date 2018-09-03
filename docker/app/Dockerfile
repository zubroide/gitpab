FROM php:7.1-fpm

# Set correct environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install packages
RUN apt update -y \
    && apt install -y ssh git zip bzip2 wget libmcrypt-dev nginx supervisor cron mc \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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
    && docker-php-ext-enable redis memcached \
    && composer global require hirak/prestissimo

# Setup web server
COPY ./app/nginx.conf /etc/nginx/sites-available/default
RUN echo "\nlisten = /var/run/php7.1-fpm.sock" >> /usr/local/etc/php-fpm.conf \
    && echo "\nlisten.owner = www-data" >> /usr/local/etc/php-fpm.conf \
    && echo "\nlisten.group = www-data" >> /usr/local/etc/php-fpm.conf \
    && echo "\nlisten.mode = 0660" >> /usr/local/etc/php-fpm.conf \
    && echo "\ndaemon off;" >> /etc/nginx/nginx.conf
COPY ./app/supervisor.conf /etc/supervisor/conf.d/gitpab.conf

# Instal npm
RUN apt update -y \
    && apt -y install gnupg \
    && curl -sL https://deb.nodesource.com/setup_8.x | bash - \
    && apt -y install nodejs

ADD ./app/entrypoint.sh /root/entrypoint.sh
ADD ./wait-for-it.sh /root/wait-for-it.sh
RUN chmod 755 /root/entrypoint.sh \
    && chmod 755 /root/wait-for-it.sh \
    && mkdir /data \
    && sed -i 's/root \/var\/www\/html;/root \/data\/www\/gitpab\/public;/g' /etc/nginx/sites-available/default

# Cron tasks (https://github.com/Ekito/docker-cron)
ADD ./app/crontab /etc/cron.d/gitpab
RUN chmod 0644 /etc/cron.d/gitpab \
    && touch /var/log/cron.log

# Deploy project
COPY ./app/.env.template /data/.env

ENTRYPOINT ["/root/entrypoint.sh"]
