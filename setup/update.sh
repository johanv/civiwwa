#!/bin/bash

# This script backups the database, pulls the code,
# and performs all necessary updates. If it is called with
# the argument 'dev', it will enable the civiwwa_dev module.


DRUSH=drush8
DOCROOT=/var/www/html
L10N=`dirname ${0}`/l10n
APACHE_GROUP=www-data


# creating backups and git pull will fail in docker, but that's ok.
# I leave it here, because it is useful on the server.

echo "Creating a backup of current databases."
echo "Don't worry if this fails on your dev environment."

mysqldump drupal | gzip > /var/bak/drupal_`date +%Y-%m-%d_%Hu%M`.sql.gz
mysqldump civi | gzip > /var/bak/civi_`date +%Y-%m-%d_%Hu%M`.sql.gz

pushd $DOCROOT

git pull

$DRUSH cc all
$DRUSH vset maintenace_mode 1
$DRUSH migrate-register

$DRUSH cvupdb
$DRUSH cvapi Extension.refresh
$DRUSH updatedb -y

# Fra twice, in case one feature depends on another that's not enabled yet.
$DRUSH fra -y
$DRUSH fra -y
$DRUSH cc all

$DRUSH -u 1 cvapi Extension.upgrade
$DRUSH -u 1 cvapi ApiAccess.reconfigure

if [ "$1" = "dev" ]
then
    $DRUSH en -y civiwwa_dev
    $DRUSH cvapi Extension.disable key=uk.co.vedaconsulting.mailchimp
fi

$DRUSH vset maintenance_mode 0
$DRUSH cc all

$DRUSH uli --uri=http://localhost
$DRUSH cc all
popd
