FROM php:apache
MAINTAINER johan.vervloet@chiro.be

# hack because otherwise I cannot build this from home. Thank you telenet :-(
# see https://github.com/rgeissert/http-redirector/issues/74#issuecomment-241682578
RUN sed -i "s/httpredir.debian.org/`curl -s -D - http://httpredir.debian.org/demo/debian/ | awk '/^Link:/ { print $2 }' | sed -e 's@<http://\(.*\)/debian/>;@\1@g'`/" /etc/apt/sources.list
RUN apt-get update && apt-get install -yq mysql-client libxml2-dev libmcrypt-dev libpng12-dev
RUN docker-php-ext-install xml mcrypt gd mysqli pdo pdo_mysql mbstring

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN echo "[PHP] \n\
memory_limit = 256M \n\
max_execution_time = 120 \n\
" > /usr/local/etc/php/php.ini
