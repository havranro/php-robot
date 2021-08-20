Task 3 - Robot
==============

Installation
------------
First, you will need to install Docker following the instructions on their site.

```sh
composer install --dev
```

Then, simply run the following command:

```sh
docker-compose up -d
```
Exec to the php container:
```sh
docker exec -it php bash
```

Robot Control
------------
Place robot on some place
```sh
php index.php robot:place PLACE  --x 0 --y 0 --facing NORTH
```

Move robot with size (argument 1 = N units on 5x5 table)
```sh
php index.php robot:move 1
```

Move robot facing LEFT/RIGHT
```sh
php index.php robot:facing LEFT
```

Fix code style:
```sh
vendor/bin/php-cs-fixer fix app/ 
```

Analyse code:
```sh
vendor/bin/phpstan analyse -l 7 app/
```
