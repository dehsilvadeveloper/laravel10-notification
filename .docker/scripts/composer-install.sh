#!/usr/bin/.env bash
source $(dirname "$0")/colors.sh

options=(`docker container ls --filter "label=php" --format "{{.Names}}"`)

echo -e $YELLOW_COLOR"Running composer Install..."$RESET_COLOR
docker-compose -f ./docker-compose.yml exec main composer install --no-interaction