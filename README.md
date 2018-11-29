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
sudo chmod a+w PandaMD PandaMD/storage/logs
cd PandaMD
composer install
php artisan migrate
php artisan db:seed #Only if we want default data
```

## Queue manager
Converting markdown to pdf takes time so we make this in a queue in background.
### Run on server
We will install and configure supervisor, he makes sure that the queue always turns.
```sh
sudo apt insatll supervisor
```
Create /etc/supervisor/conf.d/ with the following content :
```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
directory=/home/poweruser/www/PandaMD/
command=php artisan queue:work --tries=1
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/home/poweruser/www/logs/worker.log
```

```sh
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl restart all
```
### Run on local
```sh
php artisan queue:work --tries=1
```

# Test
## Requirements
### Server
Create .env.testing with the following content :
```
DB_SCHEMA=test
```
### Local
Copy .env in .env.testing and change the schema of the DB.

## Before running test
```sh
php artisan config:clear
php artisan migrate --seed --env=testing
```

## Run test
```sh
./vendor/bin/phpunit
```