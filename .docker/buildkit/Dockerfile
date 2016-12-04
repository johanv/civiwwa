FROM php:cli
MAINTAINER johan.vervloet@chiro.be

RUN apt-get update \
  && apt-get install -yq mysql-client libxml2-dev libmcrypt-dev libpng12-dev git unzip zip \
  && docker-php-ext-install xml mcrypt gd pdo pdo_mysql mysqli mbstring \
  && git clone https://github.com/civicrm/civicrm-buildkit.git /opt/buildkit

# install recent version of npm instead of the one in the standard repo's, otherwise building buildkit fails.

RUN curl -sL https://deb.nodesource.com/setup_7.x | bash - \
  && apt-get install -yq bzip2 nodejs

RUN cd /opt/buildkit && ./bin/civi-download-tools

RUN groupadd civi \
  && useradd -g civi -m civi \
  && chown -R civi /opt/buildkit \
  && chmod -R ug+rwX /opt/buildkit \
  && mkdir -p /var/www/html \
  && chown -R civi:www-data /var/www \
  && chmod -R ug+rwX /var/www \
  && echo "[client] \n\
user=root \n\
password=blablablaroot \n\
host=db " > /home/civi/.my.cnf \
  && su -c "/opt/buildkit/bin/amp config:set --db_type=mysql_mycnf --hosts_type=none --perm_type=worldWritable" civi

ENV PATH /opt/buildkit/bin:$PATH

