#!/bin/bash

# STDERR log function
logError() {
  echo -e "\n[$(date +'%Y-%m-%dT%H:%M:%S%z')]: $@\n" >&2
  exit 1
}