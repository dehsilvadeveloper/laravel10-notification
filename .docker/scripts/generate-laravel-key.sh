#!/usr/bin/env bash
source $(dirname "$0")/colors.sh

echo -e $YELLOW_COLOR"Generating Laravel key..."$RESET_COLOR
docker-compose -f ./docker-compose.yml exec main php artisan key:generate