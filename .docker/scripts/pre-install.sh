#!/bin/bash
source $(dirname "$0")/colors.sh

echo $BLUE_COLOR"Initializing Docker and Docker-compose installation check."$RESET_COLOR

# Check if Docker is installed
if ! type "docker" >/dev/null 2>&1; then
  echo $RED_COLOR"Docker not installed."$RESET_COLOR
  exit 1
fi

# Check if Docker-compose is installed
if ! type "docker-compose" >/dev/null 2>&1; then
  echo $RED_COLOR"Docker-Compose not installed."$RESET_COLOR
  exit 1
fi

echo $GREEN_COLOR"Docker and Docker-compose are installed, things are looking good."$RESET_COLOR

echo $GREEN_COLOR"Good to go. Move on."$RESET_COLOR
