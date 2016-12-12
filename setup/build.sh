#!/bin/bash

DRUSH=drush8
CHGRP=chgrp
CHMOD=chmod
DOCROOT=/var/www/html
L10N=`dirname ${0}`/l10n

mkdir $L10N 2> /dev/null

pushd $L10N
wget -nc https://download.civicrm.org/civicrm-4.7.13-l10n.tar.gz
popd

mysql -h db << EOF
drop database if exists civi;
create database civi;
grant all on civi.* to dev;
EOF

pushd $DOCROOT
$DRUSH si minimal --db-url=mysql://dev:DbDevPw@db/drupal --db-su=root --db-su-pw=blablablaroot --site-name="CivIWWA" --locale=nl --account-name=civiwwadmin --account-mail=helpdesk@johanv.org -y

$CHMOD -R ugo+rwx sites/default
echo Installing CiviCRM.
$DRUSH --include=/var/www/html/sites/all/modules/civicrm/drupal/drush cvi --dbuser=dev --dbpass=DbDevPw --dbhost=db --dbname=civi --destination=./sites/all/modules --site_url=localhost --lang=nl_NL --langtarfile=$L10N/civicrm-4.7.13-l10n.tar.gz
$CHMOD -R go-w sites/default

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

# chgrp inside the container, to get the correct id for www-data.
# $CHGRP -R $APACHE_GROUP /var/www/html/sites/default/files
# $CHMOD -R ug+rwX sites/default/files

popd
