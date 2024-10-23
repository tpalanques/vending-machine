# 0. Vending Machine

Senior developer test for some customer

# 1. Scripts

The bash scripts are included to easy some features. Those need to be executed
from the scripts folder, so you'll probably need to go there before executing
them:

```shell
cd {holded-vending-machine}/system/scripts
```

## 1.1 Docker start/stop/restart

To start, stop or restart the project just type on of the following commands:

```shell
. docker.sh start
```

```shell
. docker.sh stop
```

```shell
. docker.sh restart
```

## 1.2 Docker list

You can check the current running machines by typing:

```shell
. docker.sh list
```

## 1.3 Composer update

You can update the composer dependencies by running:

```shell
. docker.sh composerUpdate  
```
Note this will get or update your json.lock file

## 1.4 Run test suite

The project includes several unit tests, they can be run with the following script:

```shell
. test.sh run  
```
# 2 File structure

## 2.0 Root
The `root` directory contains 3 main folders (further explained) and the docker-compose.yml
Docker composition is not ment to be run directly with docker scripts but with the scripts 
contained in `system/scripts`

## 2.1 System
The `system` folder contains scripts and configuration files to build the entire project

## 2.2 Storage
The `storage` folder contains persistent data and shouldn't be deleted unless you want to remove your data

## 2.3 Src
The `src` folder contains the working code (including tests) to run the project

# 3. Running the machine
To get the machine working you'll need to build the docker machine previously (see point 1). Once the
machine is built you can run the script:

```shell
. run.sh

```
