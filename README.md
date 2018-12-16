# PandaMD
PandaMD is an application that converts markdown files in report in pdf format.

# Installation
## Pandoc
```sh
wget https://github.com/jgm/pandoc/releases/download/2.4/pandoc-2.4-1-amd64.deb
sudo dpkg -i pandoc-2.4-1-amd64.deb
rm pandoc-2.4-1-amd64.deb
```

## Texlive
```sh
sudo apt install texlive-full
```

## Template for pandoc
```sh
cd /usr/share/pandoc/data/templates
sudo wget https://raw.githubusercontent.com/steven-jeanneret/dotFiles/master/pandoc/eisvogel.latex
```

## PandaMD
We need to give write permission to the user who will execute the queue worker. 
```sh
git clone https://github.com/HE-Arc/PandaMD.git
cd PandaMD
composer install
php artisan migrate
php artisan db:seed #Only if we want default data
```

## Queue manager
Converting markdown to pdf takes time so we make this in a queue in background.
### Run on server
We will configure sv, he makes sure that the queue will always turns.

Create /etc/service/laravel-queue-worker/run with the following content :
```
#!/bin/sh
set -xe
cd /var/www/PandaMD
exec 2>&1
exec chpst -uwww-data php artisan queue:work
```

```sh
sudo chmod a+x run
sudo sv start laravel-queue-worker
```
### Run on local
```sh
php artisan queue:work
```

# Test
## Requirements
### Server
Create .env.testing with the following content :
```
DB_SCHEMA=test
```
Create Schema test in database

### Local
Copy .env in .env.testing and change the schema of the DB.

## Before running test
```sh
php artisan config:clear
php artisan migrate --seed --env=testing
```

## Run test
Linux:
```sh
./vendor/bin/phpunit
```
Windows:
```sh
"./vendor/bin/phpunit"
```

