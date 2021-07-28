# Deployment

This document describes the steps to deploy the app on an Apache server.

## TODO

- Find a way to store default user in the db without using the `--seed` option when running
 the database migrations the first time. See `htpasswd` command and `sqlite3`. See if there
 is `bcrypt` function in SQL.

## Clone the Repository

The app will be installed in `/srv/apache/pb`.

```
sudo mkdir -p /srv/apache/pb
```

Change the new directory owner, so that you can change its contents.

```bash.
sudo chown <you>:<your group> /srv/apache/pb
```

Finally clone the repository.

```
cd /srv/apache/pb
git clone git@github.com:kitihounel/pb.git .
```

## Install App Dependencies

```bash
composer install
```

## Set Environment Variables

Create the `.env` file.

```bash
cp .env.example .env
```

Set values for required variables.

```env
APP_NAME="Prescription Book"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://pb.local
APP_TIMEZONE="Africa/Porto-Novo"

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=sqlite
DB_DATABASE=/srv/apache/pb/database/db.sqlite
DB_FOREIGN_KEYS=true

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

Generate application key.

```
php artisan key:generate
```

## Run Database Migrations 

```bash
php artisan migrate:fresh # You can use the --seed option, although it is not recommended in production.
```

Note that we can use the `--seed` option to have our test user created for us.

## Give Apache User Write Permissions to Storage Folder

You need to give write permissions on the `storage` folder to the user which runs the web server
process to enable the app logs and caching.

Usually, the user is `www-data` and the group is also `www-data`. To find that user, run the
following command:

```bash
ps -ef | egrep '(httpd|apache2|apache)' | grep -v root | head -n1 | awk '{print $1}'
```

After that, you can get his group with (here we use `www-data` as user):

```bash
groups www-data
```

Finally change the group ownership of the `storage` folder. We only need to change the group,
not the owner.

```
cd /srv/apache/pb
sudo chgrp -R www-data  ./storage
```

You need to run the command as root. See this SO thread for the reason: https://superuser.com/questions/375464.

## Configure Apache to Serve The App

First of all, make sure that `mod_rewrite` is enabled.

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

We need to create a new virtual host. Create a file `001-pb.conf` under `/etc/apache2/sites-available`.

```bash
cd /etc/apache2/sites-available
touch 001-pb.conf
```

Copy the following content in the file.

```apache
<VirtualHost *:80>
  ServerName pb.local
  ServerAlias www.pb.local

  DocumentRoot /srv/apache/pb/public
  DirectoryIndex /index.php

  <Directory /srv/apache/pb/public>
    AllowOverride All
    Require all granted

    FallbackResource /index.php
  </Directory>

  ErrorLog /var/log/apache2/pb_error.log
  CustomLog /var/log/apache2/pb_access.log combined
</VirtualHost>
```

Then enable the new site.

```bash
sudo a2ensite 001-pb
```

Add the new site address in `/etc/hosts`.

```
127.0.0.1    pb.local
```

Everything should work now.

## Acknowledgement

- https://clouding.io/hc/en-us/articles/360013637759-How-To-Setup-Lumen-API-on-Ubuntu
- https://serverfault.com/questions/125865/finding-out-what-user-apache-is-running-as
