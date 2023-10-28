FROM php:8.2-fpm
ENV TZ=Asia/Tehran
ENV ACCEPT_EULA=Y
WORKDIR /var/www/article_alibaba

RUN apt-get -y update && apt-get -y install libssl-dev libcurl4-openssl-dev wget zip apt-utils libzip-dev libxml2-dev \
                                            libssh-dev git supervisor cron zlib1g-dev libjpeg62-turbo-dev libpng-dev \
                                            libxpm-dev libfreetype6-dev iputils-ping redis-server

RUN apt-get update -yqq \
    && apt-get install -y --no-install-recommends openssl \
    && sed -i 's,^\(MinProtocol[ ]=\).,\1'TLSv1.0',g' /etc/ssl/openssl.cnf \
    && sed -i 's,^\(CipherString[ ]=\).,\1'DEFAULT@SECLEVEL=1',g' /etc/ssl/openssl.cnf\
    && rm -rf /var/lib/apt/lists/*

RUN pecl config-set php_ini $PHP_INI_DIR/php.ini

RUN docker-php-ext-install  curl bcmath zip  iconv xml soap  pcntl pdo pdo_mysql simplexml gd

#COPY Supervisor/article_alibaba.conf /etc/supervisor/conf.d
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN printf '[PHP]\ndate.timezone="Asia/Tehran"\n' > /usr/local/etc/php/conf.d/tzone.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

