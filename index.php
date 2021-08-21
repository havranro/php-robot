<?php

require_once ('vendor/autoload.php');

use Robot\Command\RobotFacingCommand;
use Robot\Command\RobotMoveCommand;
use Robot\Command\RobotPlaceCommand;
use Robot\Command\RobotResetCommand;
use Robot\Model\Robot\Robot;
use Robot\Model\Table\Table;
use Symfony\Component\Console\Application;

$table = new Table(5);
$robot = new Robot($table);

$application = new Application();
$application->add(new RobotPlaceCommand($robot));
$application->add(new RobotMoveCommand($robot));
$application->add(new RobotFacingCommand($robot));
$application->add(new RobotResetCommand($robot));
$application->run();
