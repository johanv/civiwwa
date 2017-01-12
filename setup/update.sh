#!/bin/bash

DRUSH=drush8
DOCROOT=/var/www/html/docroot
L10N=`dirname ${0}`/l10n
APACHE_GROUP=www-data


mysqldump drupal | gzip > /var/bak/drupal_`date +%Y-%m-%d_%Hu%M`.sql.gz
mysqldump civi | gzip > /var/bak/civi_`date +%Y-%m-%d_%Hu%M`.sql.gz

pushd $DOCROOT

$DRUSH cc all
$DRUSH vset maintenace_mode 1

$DRUSH cvupdb
$DRUSH cvapi Extension.refresh
$DRUSH updatedb -y

$DRUSH fra -y
$DRUSH cc all

$DRUSH -u 1 cvapi Extension.upgrade
$DRUSH vset maintenance_mode 0
$DRUSH cc all

popd