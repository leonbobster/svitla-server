# svitla-server
Trial task for Svitla

PHP7, Symfony3.3 micro-kernel, FOSRestBundle, Doctrine2.5, JMSSerializerBundle, PHPUnit6.3

Bundle: https://github.com/leonbobster/svitla-server/tree/master/src/AppBundle

Tests: https://github.com/leonbobster/svitla-server/tree/master/tests/AppBundle

Db:

https://github.com/leonbobster/svitla-server/blob/master/db/config/my.ini

https://github.com/leonbobster/svitla-server/blob/master/docker-compose.yml


# Installation

### Clone repository:

git clone git@github.com:leonbobster/svitla-server.git

### Install dependencies:

cd svitla-server

composer install

### Run pre-configured MySQL5.7 server (Docker required):

docker-compose up -d

docker-compose down

See docker-compose.yml for information.
You can find my.ini config file with trivial tuning in /db/config.
Or you can configure connection parameters in /config/parameters.yml

### Populate db with fake-data:

php bin/console app:generate-fake-data

### Run tests:

./vendor/bin/phpunit tests/

### Run web-server:
cd public/

php -S localhost:8095
