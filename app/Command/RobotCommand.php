<?php

declare(strict_types=1);

namespace Robot\Command;

use Robot\Factory\RobotPositionFactory;
use Robot\Model\Robot\Robot;
use Robot\Model\Robot\RobotInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RobotCommand
 * @package Robot\Command
 */
class RobotCommand extends Command
{
    private const COMMAND_NAME = 'robot:move';
    private const ARGUMENT_MOVE_NAME = 'move';
    private const OPTION_MOVE_NAME = 'facing';
    private const OPTION_X_NAME = 'x';
    private const OPTION_Y_NAME = 'y';

    private Robot $robot;

    public function __construct(
        Robot $robot,
        string $name = null
    ) {
        parent::__construct($name);
        $this->robot = $robot;
    }

    /**
     * Configure command
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Robot move or place')
            ->setHelp('Enabled move types: PLACE, MOVE example: PLACE --x 0 --y 0 --facing NORTH')
            ->addArgument(
                self::ARGUMENT_MOVE_NAME,
                InputArgument::REQUIRED,
                'Robot move command'
            )
            ->addOption(self::OPTION_X_NAME, null, InputOption::VALUE_REQUIRED)
            ->addOption(self::OPTION_Y_NAME, null, InputOption::VALUE_REQUIRED)
            ->addOption(self::OPTION_MOVE_NAME, null, InputOption::VALUE_OPTIONAL);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $robotMoveType = $input->getArgument(self::ARGUMENT_MOVE_NAME);

        $robotSideType = $input->getOption(self::OPTION_MOVE_NAME);
        $x = $input->getOption(self::OPTION_X_NAME);
        $y = $input->getOption(self::OPTION_Y_NAME);

        if (
            !in_array($robotMoveType, RobotInterface::MOVE_TYPES, true) ||
            !in_array($robotSideType, RobotInterface::SIDE_TYPES, true)
        ) {
            $output->writeln('Iam sorry, I cant do this. Check move type or word side type');

            return Command::FAILURE;
        }

        if ($robotMoveType === RobotInterface::MOVE_TYPE_MOVE && !$this->robot->getRobotPosition()->isPositionSetted()) {
            $output->writeln('Please set valid position for robot with PLACE command example: PLACE --x 0 --y 0 --facing NORTH');

            return Command::FAILURE;
        }

        if ($robotMoveType === RobotInterface::MOVE_TYPE_PLACE) {
            $newPosition = RobotPositionFactory::create((int) $x, (int)$y, $robotSideType);

            try {
                $actualPosition = $this->robot->place($newPosition)->getRobotPosition();
                $output->writeln('OUTPUT:' . $actualPosition->toString());

            } catch (\Exception $e) {
                $output->writeln($e->getMessage());
            }

            return Command::SUCCESS;
        }

        if ($robotMoveType === RobotInterface::MOVE_TYPE_MOVE) {
            print_r($this->robot);die();
        }
    }
}
