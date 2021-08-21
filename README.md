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

Reset robot (delete all previous positions - need place)
```sh
php index.php robot:reset
```

Examples:
------------
Place to 0,0 NORTH, then move -> OUT: 0,1 NORTH
```sh
php index.php robot:place PLACE --x 0 --y 0 --facing NORTH
php index.php robot:move 1
```

Place to 0,0 NORTH, then change facing LEFT -> OUT: 0,0 WEST
```sh
php index.php robot:place PLACE --x 0 --y 0 --facing NORTH
php index.php robot:facing LEFT
```

PLACE 1,2 EAST MOVE MOVE LEFT MOVE -> OUT: 3,3,NORTH
```sh
php index.php robot:place PLACE --x 1 --y 2 --facing EAST
php index.php robot:move 1
php index.php robot:move 1
php index.php robot:facing LEFT
php index.php robot:move 1
```

Dev tools (all commands in container)
------------
Run tests:
```sh
php vendor/bin/codecept run
```

Fix code style:
```sh
vendor/bin/php-cs-fixer fix app/ 
```

Analyse code:
```sh
vendor/bin/phpstan analyse -l 4 app/
```
