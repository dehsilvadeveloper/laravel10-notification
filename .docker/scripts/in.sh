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
            echo $YELLOW_COLOR"Entering $opt..."$RESET_COLOR
            docker exec -it $opt /bin/sh
            break 2;
        fi
    done
done
