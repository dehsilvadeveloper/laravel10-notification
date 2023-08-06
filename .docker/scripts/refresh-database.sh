#!/usr/bin/.env bash
source $(dirname "$0")/colors.sh

echo -e $YELLOW_COLOR"Regenerating / dumping autoload..."$RESET_COLOR
docker-compose -f ./docker-compose.yml exec main composer dump-autoload

echo -e $YELLOW_COLOR"Dropping all tables and re-running migrations..."$RESET_COLOR
docker-compose -f ./docker-compose.yml exec main php artisan migrate:refresh

echo -e $YELLOW_COLOR"Re-running all seeds..."$RESET_COLOR
docker-compose -f ./docker-compose.yml exec main php artisan db:seed