#!/usr/bin/.env bash
source $(dirname "$0")/colors.sh

options=(`docker container ls --filter "label=php" --format "{{.Names}}"`)

echo -e $YELLOW_COLOR"Regenerating / dumping autoload..."$RESET_COLOR
docker-compose -f ./docker-compose.yml exec main composer dump-autoload -o