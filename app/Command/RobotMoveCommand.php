<?php

declare(strict_types=1);

namespace Robot\Command;

use Exception;
use Robot\Model\Robot\Robot;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RobotCommand
 * @package Robot\Command
 */
class RobotMoveCommand extends Command
{
    private const COMMAND_NAME = 'robot:move';
    private const ARGUMENT_MOVE_SIZE_NAME = 'size';

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
            ->setDescription('Robot move')
            ->addArgument(
                self::ARGUMENT_MOVE_SIZE_NAME,
                InputArgument::REQUIRED,
                'Robot move command'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moveSize = $input->getArgument(self::ARGUMENT_MOVE_SIZE_NAME);

        if (!$this->robot->getActualPosition()->isPositionSetted()) {
            $output->writeln('Please set valid position for robot with PLACE command example: PLACE --x 0 --y 0 --facing NORTH');

            return Command::FAILURE;
        }

        try {
            $actualPosition = $this->robot->move((int )$moveSize)->getActualPosition();

            $output->writeln('OUTPUT:' . $actualPosition->toString(true));
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
        }

        return Command::SUCCESS;
    }
}
