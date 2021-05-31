#!/bin/bash -e

log() {
  echo -e "${NAMI_DEBUG:+${CYAN}${MODULE} ${MAGENTA}$(date "+%T.%2N ")}${RESET}${@}" >&2
}

init_project() {
  log "Init project"
  cd /var/www/html
  if [ ! `cat .env | grep APP_KEY=.` ]
  then
    php artisan key:generate
    php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\ServiceProvider" --tag=assets
  fi
  chown -R www-data:www-data /var/www/html
  chmod -R g+w /var/www/html
}

setup_db() {
  log "Configuring the database"
  php artisan cache:clear
  php artisan migrate --force
  php artisan db:seed --class=DatabaseSeeder
  php artisan db:seed --class=UserSeeder
  php artisan cache:clear
  php artisan view:clear
}

load_data() {
  log "Loading data from Gtilab"
  php artisan import:all
}

log "Waiting for Postgres..."
/root/wait-for-it.sh db:5432 --timeout=180 -- echo "PostgreSQL started"

init_project
setup_db
load_data

log "Start cron"
printenv | sed 's/^\(.*\)$/export \1/g' | grep -E "^export GITLAB" > /root/project_env.sh
service cron start

log "Start php-fpm"
php-fpm
