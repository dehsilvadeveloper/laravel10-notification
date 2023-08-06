#!/usr/bin/env bash
source $(dirname "$0")/colors.sh

ASK=$BLUE_COLOR"Please enter your choice: "$RESET_COLOR
EXIT="exit"
PS3=$ASK

options=(`docker container ls --format "{{.Names}}"`)

select opt in "${options[@]}" $EXIT
do
    if [[ $opt == $EXIT || $REPLY == 'exit' ]]; then
        break;
    fi

    for item in "${options[@]}"; do
        if [[ $item == $opt ]]; then
            echo -e $YELLOW_COLOR"Stopping $opt..."$RESET_COLOR
            docker stop $opt
            break 2;
        fi
    done
done
