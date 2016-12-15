#!/bin/bash

DRUSH=drush8
DOCROOT=/var/www/html
L10N=`dirname ${0}`/l10n

mkdir $L10N 2> /dev/null

pushd $L10N
# CiviCRM installation seems to unzip the tar.gz file, and leaves
# a tar file. So if a tar file already exists, just zip it again.
gzip civicrm-4.7.13-l10n.tar
wget -nc https://download.civicrm.org/civicrm-4.7.13-l10n.tar.gz
popd

mysql -h db << EOF
drop database if exists civi;
create database civi;
-- recreate drupal to make sure migrations are gone.
drop database if exists drupal;
create database drupal;
grant all on civi.* to dev;
EOF

pushd $DOCROOT
$DRUSH si minimal --db-url=mysql://dev:DbDevPw@db/drupal --db-su=root --db-su-pw=blablablaroot --site-name="CivIWWA" --locale=nl --account-name=civiwwadmin --account-mail=helpdesk@johanv.org -y

chmod -R ugo+rwx sites/default
drush cc all
echo Installing CiviCRM.
$DRUSH --include=$DOCROOT/sites/all/modules/civicrm/drupal/drush cvi --dbuser=dev --dbpass=DbDevPw --dbhost=db --dbname=civi --destination=./sites/all/modules --site_url=localhost --lang=nl_NL --langtarfile=$L10N/civicrm-4.7.13-l10n.tar.gz
chmod -R go-w sites/default

APACHE_GROUP=www-data


rm -rf sites/default/files/civicrm/templates_c/*
rm -rf sites/default/files/civicrm/ConfigAndLog/CiviCRM.*

## revert features, by design followed by double cache clear
$DRUSH fra -y
$DRUSH cc all
$DRUSH cc all

## deploy

$DRUSH en -y civiwwa_deploy

## TODO: enable devel.

$DRUSH vset clean_url 0

chown -R civi:www-data /var/www/html/sites/default/files
chmod -R ug+rwX sites/default/files

$DRUSH cc all
$DRUSH migrate-register
$DRUSH ms
$DRUSH migrate-import people

chown -R civi:www-data /var/www/html/sites/default/files
chmod -R ug+rwX sites/default/files

$DRUSH uli --uri=http://localhost
popd
