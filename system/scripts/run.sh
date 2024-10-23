#!/bin/bash

source config.sh
source system.sh

. docker.sh runCommandInContainer "php index.php" $PHP_CONTAINER_NAME
