FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y libzip-dev \
        && docker-php-ext-install zip

# 1. development packages
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
    python-is-python3 \
    cron \
    vim \
    default-mysql-client


RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# 2. apache configs + document root
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

#apache ssl cert & config
COPY apache/ssl/server.pem /etc/ssl/certs/server.pem
COPY apache/ssl/key.pem /etc/ssl/private/key.pem
COPY apache/admin.plurality.moda.gov.tw.conf /etc/apache2/sites-enabled/admin.plurality.moda.gov.tw.conf
COPY apache/admin.plurality.moda.gov.tw.ssl.conf /etc/apache2/sites-enabled/admin.plurality.moda.gov.tw.ssl.conf

# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers ssl

# 4. start with base php config, then add extensions
COPY apache/php.ini "$PHP_INI_DIR/php.ini"

ARG uid=1000
ENV APACHE_RUN_USER devuser
ENV APACHE_RUN_GROUP devuser


# 5. install prerequisite
RUN docker-php-ext-configure zip
RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    zip


# 6. we need a user with the same UID/GID with host user
# so when we execute CLI commands, all the host file's ownership remains intact
# otherwise command from inside container will create root-owned files and directories

RUN useradd -G www-data,root -u $uid -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

RUN service apache2 restart

EXPOSE 80
EXPOSE 443

# 7. run prerequisite for laravel app
WORKDIR /var/www/html
COPY . .
#RUN mv .env.production .env

RUN chown -R devuser:devuser .
RUN chmod 440 .env

RUN php artisan key:generate

RUN php artisan storage:link

RUN php artisan cache:clear

RUN php artisan config:cache


# 10. Set server timezone
RUN apt-get update \
    &&  DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends tzdata
    
RUN TZ=Asia/Taipei \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata 

