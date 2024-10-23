#!/bin/bash

source config.sh
source system.sh

setOriginalPath
setEnvironment

function start() {
  cd $ROOT_PATH
  sudo service docker start
  sudo docker-compose up --detach --force-recreate --remove-orphans --always-recreate-deps --build
  sudo docker-compose logs php
  cdOriginalPath
}

function runCommandInContainer() {
  cd $ROOT_PATH
  sudo docker exec -it $2 $1
  cdOriginalPath
}

function list() {
  sudo docker container list
}

function composerUpdate() {
   sudo docker-compose run --rm php composer install
   sudo docker-compose run --rm php composer update
}

function stop() {
  cd $ROOT_PATH
  sudo docker-compose down
  sudo service docker stop
  cdOriginalPath
}

command=$1
case $command in
runCommandInContainer)
  containerCommand=$2
  containerName=$3
  runCommandInContainer "$containerCommand" $containerName
  ;;
restart)
  stop
  start
  ;;
start)
  start
  ;;
stop)
  stop
  ;;
list)
  list
  ;;
composerUpdate)
  composerUpdate
  ;;
*)
  echo "Command not found"
  ;;
esac
