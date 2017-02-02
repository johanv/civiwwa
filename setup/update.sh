#!/bin/bash

DRUSH=drush8
DOCROOT=/var/www/html
L10N=`dirname ${0}`/l10n
APACHE_GROUP=www-data


# creating backups and git pull will fail in docker, but that's ok.
# I leave it here, because it is useful on the server.

mysqldump drupal | gzip > /var/bak/drupal_`date +%Y-%m-%d_%Hu%M`.sql.gz
mysqldump civi | gzip > /var/bak/civi_`date +%Y-%m-%d_%Hu%M`.sql.gz

pushd $DOCROOT

git pull

$DRUSH cc all
$DRUSH vset maintenace_mode 1

$DRUSH cvupdb
$DRUSH cvapi Extension.refresh
$DRUSH updatedb -y

$DRUSH fra -y
$DRUSH cc all

$DRUSH -u 1 cvapi Extension.upgrade
$DRUSH -u 1 cvapi ApiAccess.reconfigure
$DRUSH vset maintenance_mode 0
$DRUSH cc all

$DRUSH uli --uri=http://localhost
popd