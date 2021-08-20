<?php

declare(strict_types=1);

namespace Robot\Command;

use Exception;
use Robot\Model\Robot\Robot;
use Robot\Model\Robot\RobotInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RobotCommand
 * @package Robot\Command
 */
class RobotFacingCommand extends Command
{
    private const COMMAND_NAME = 'robot:facing';
    private const ARGUMENT_MOVE_FACING_NAME = 'facing';

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
                self::ARGUMENT_MOVE_FACING_NAME,
                InputArgument::REQUIRED,
                'Robot move command'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $newFacing = $input->getArgument(self::ARGUMENT_MOVE_FACING_NAME);

        if (!$this->robot->getActualPosition()->isPositionSetted()) {
            $output->writeln('Please set valid position for robot with PLACE command example: PLACE --x 0 --y 0 --facing NORTH');

            return Command::FAILURE;
        }

        if (!in_array($newFacing, RobotInterface::FACING_TYPES, true)) {
            $output->writeln('Iam sorry, I cant do this. LEFT or RIGHT is available');

            return Command::FAILURE;
        }

        try {
            $actualPosition = $this->robot->changeFacing($newFacing)->getActualPosition();

            $output->writeln('OUTPUT:' . $actualPosition->toString(true));
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

        return Command::SUCCESS;
    }
}
