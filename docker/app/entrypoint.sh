#!/bin/bash -e

log() {
  echo -e "${NAMI_DEBUG:+${CYAN}${MODULE} ${MAGENTA}$(date "+%T.%2N ")}${RESET}${@}" >&2
}

clone_project() {
  log "Cloning project"
  mkdir -p /data/www
  cd /data/www
  if [ ! -d gitpab ]
  then
    git clone https://github.com/zubroide/gitpab.git
    cd gitpab
    cp /data/.env .env
    composer install
    php artisan key:generate
    php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\ServiceProvider" --tag=assets
  else
    cd gitpab
    git pull
  fi
  chown -R www-data:www-data /data/www
  chmod -R g+w /data
  cd /data/www/gitpab
  composer install
  npm install
  npm run prod
}

setup_db() {
  log "Configuring the database"
  php artisan migrate --force
  php artisan db:seed --class=DatabaseSeeder
  php artisan db:seed --class=UserSeeder
}

load_data() {
  log "Loading data from Gtilab"
  php artisan import:all
}

/root/wait-for-it.sh db:5432 -- echo "PostgreSQL started"

clone_project
setup_db
load_data

supervisord -n
