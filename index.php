<?php

require_once ('vendor/autoload.php');

use Robot\Command\RobotCommand;
use Robot\Model\Table\Table;
use Symfony\Component\Console\Application;

$table = new Table(5);
$robot = new \Robot\Model\Robot\Robot($table);

$application = new Application();
$application->add(new RobotCommand($robot));
$application->run();
