![phalcon5-skeleton](https://raw.githubusercontent.com/notesz/phalcon5-skeleton/refs/heads/main/phalcon5-skeleton.png)

# phalcon5-skeleton

A private skeleton for new projects based on PHP 8 and Phalcon 5

## Install

You can download this project [here](https://github.com/notesz/phalcon5-skeleton/releases). \
Unzip files to your docroot and make these permissions

```shell
chmod -R 777 cache
chmod -R 777 data
chmod 755 cli
chmod 755 scheduler
```

Make a .env from .env.example and edit it

```shell
cp .env.example .env
vi .env
```

Run composer to install dependencies

```shell
composer install
```

Run phalcon migration to build the database

```shell
php ./vendor/bin/phalcon-migrations run
```

Run npm build

```shell
npm init -y
npm install webpack webpack-cli --save-dev
npm run build
```

That's all.
