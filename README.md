# CivIWWA

Just another CiviCRM instance.

I'll post some documentation later on.

# How to run locally

Remove the `.dist` from the files in `docroot/sites/default`.
```
cd docroot/sites/default
for file in *.dist
do
  cp $file `basename $file .dist`
done
```

Put the csv files needed for migrations in 
`docroot/sites/all/modules/custom/civiwwa_migrate/data_sources`.
If you have a local web server running on port 80, stop it first.
And then

```
sudo docker-compose up -d
```

## Initial setup

I used to have this script for initial setup, but it probably
won't work anymore:

```
sudo docker-compose exec buildkit /opt/setup/build.sh
```

## Copy from live (need ssh access to server)

```
sudo docker-compose exec buildkit /opt/setup/createdevfromlive.sh
```

You will get errors because the script tries to write backups
where it shouldn't, and because it tries to git pull without
`.git` being available from inside the container. But don't
worry about these.

## Connect to your instance

You can now connect on http://localhost/

You might want to create an alias for drush:

```
alias drush='sudo docker-compose exec buildkit drush --root=/var/www/html'
```

Or you can access the build environment:

```
sudo docker-compose exec buildkit /bin/bash
```
