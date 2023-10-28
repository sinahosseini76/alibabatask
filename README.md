
# Sourceinja Online Manu

## Overview

1. [Install prerequisites](#install-prerequisites)

   Before installing project make sure the following prerequisites have been met.

2. [Clone the project](#clone-the-project)

   We’ll download the code from its repository on GitHub.

5. [Run the application](#run-the-application)

   By this point we’ll have all the project pieces in place.
___

## Install prerequisites

For now, this project has been mainly created for Unix `(Linux/MacOS)`. Perhaps it could work on Windows.

All requisites should be available for your distribution. The most important are :

* [Git](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-20-04)
* [Docker](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04)
* [Docker Compose](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04)

Check if `docker-compose` is already installed by entering the following command :

```sh
which docker-compose
```

Check Docker Compose compatibility :

* [Compose file version 3 reference](https://docs.docker.com/compose/compose-file/)

The following is optional but makes life more enjoyable :

```sh
which make
```

On Ubuntu and Debian these are available in the meta-package build-essential. On other distributions, you may need to install the GNU C++ compiler separately.

```sh
sudo apt install build-essential
```

### Images to use

* [Nginx](https://hub.docker.com/_/nginx/)
* [MySQL](https://hub.docker.com/_/mysql/)
* [PHP-FPM](https://hub.docker.com/r/nanoninja/php-fpm/)
* [Composer](https://hub.docker.com/_/composer/)

You should be careful when installing third party web servers such as MySQL or Nginx.

This project use the following ports :

| Server     | Port |
|------------|------|
| MySQL      | 3320 |
| Nginx      | 8030 |
| redis      | 6390 |
| php        | 9100 |


___

## Clone the project

To install [Git](http://git-scm.com/book/en/v2/Getting-Started-Installing-Git), download it and install following the instructions :

```sh
git clone https://gitlab.com/resturant-management-system/onlinemenu
```

Go to the project directory :

```sh
cd onlinemenu
```

### Project tree

```sh
.
├── Docker
│   └── data
│       ├── mysql
│       └── redis
│   └── mysql
│       ├── .env
│       └── .env.example
│   └── nginx
│       └── conf.d
│            ├── dumps
│       └── Dockerfile
│   └── php
│       └── Dockerfile
│   └── redis
│       ├── conf
│       └── Dockerfile
└── application
    └── public
        └── index.php
├── docker-compose.yml
├── README.md
        
```
___

## Run the application

1. Copying the composer configuration file :

    ```sh
    cp application/.env.example application/.env
    cp docker/mysql/.env.example docker/mysql/.env
    ```

2. Start the application :

    ```sh
    docker-compose up -d --build
    ```

   **Please wait this might take a several minutes...**

    ```sh
    docker-compose logs -f # Follow log output
    ```
3. run migration

    ```sh
    docker exec  -it article_alibaba_php php artisan migrate --seed
    ```
4. Stop and clear services

    ```sh
    sudo docker-compose down -v
    ```

___

## Help us

Any thought, feedback or (hopefully not!)
