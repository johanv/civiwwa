#!/bin/bash

MYSQLPARAMS="-u root -pblablablaroot -h 172.26.0.2"

mysql $MYSQLPARAMS << EOF
DROP DATABASE IF EXISTS drupal;
DROP DATABASE IF EXISTS civi;
CREATE DATABASE drupal;
CREATE DATABASE civi;
EOF

ssh root@civiwwa.johanv.org 'cat `ls -t /var/bak/drupal* | head -1`' | gunzip | mysql $MYSQLPARAMS drupal
ssh root@civiwwa.johanv.org 'cat `ls -t /var/bak/civi* | head -1`' | gunzip | mysql $MYSQLPARAMS civi

`dirname ${0}`/update.sh dev
