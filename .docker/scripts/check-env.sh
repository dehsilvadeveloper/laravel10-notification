#!/usr/bin/env bash
source $(dirname "$0")/colors.sh

echo $BLUE_COLOR"Checking existence of .env file."$RESET_COLOR

if [ ! -f ./.env ]; then
    echo "Copying .env.example -> .env"
    cp ./.env.example ./.env
fi

if [ ! -f ./.env ]; then
    echo $RED_COLOR"The file .env does not exists. We have a problem."$RESET_COLOR
    exit 1
fi

echo $GREEN_COLOR"The file .env exists, things are looking good."$RESET_COLOR

echo $GREEN_COLOR"Good to go. Move on."$RESET_COLOR
