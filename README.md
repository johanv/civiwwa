# CivIWWA

Just another CiviCRM instance.
Nothing to see here, move along :-)

# How to run locally

You can run this using docker-compose. But first you have to rename
`docroot/sites/default/settings/example.my.settings.php` and
`docroot/sites/default/settings/example.my.civicrm.settings.php` to
`docroot/sites/default/settings/my.settings.php` and
`docroot/sites/default/settings/my.civicrm.settings.php` respectively, and
adapt them to your needs.

Put the csv files needed for initial migration in 
`docroot/sites/all/modules/custom/civiwwa_migrate/data_sources`. And then:

(If you have a local web server running on port 80, stop it first.)

```
sudo docker-compose up -d
sudo docker-compose exec buildkit /opt/setup/build.sh
```

You can now connect on http://localhost/

You might want to create an alias for drush:

```
alias drush='sudo docker-compose exec buildkit drush --root=/var/www/html'
```

Or you can access the build environment:

```
sudo docker-compose exec buildkit /bin/bash
```
