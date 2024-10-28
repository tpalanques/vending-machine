#!/bin/bash

source config.sh
source docker.sh
source system.sh

setOriginalPath
setEnvironment

function run() {
  cd $ROOT_PATH
  runCommandInContainer "php vendor/phpunit/phpunit/phpunit app" "$PHP_CONTAINER_NAME"
}

command=$1
case $command in
run)
  run
  ;;
*)
  echo "Command not found"
  ;;
esac
