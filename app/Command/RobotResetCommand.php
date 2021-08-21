<?php

declare(strict_types=1);

namespace Robot\Command;

use Robot\Model\Robot\Robot;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RobotCommand
 * @package Robot\Command
 */
class RobotResetCommand extends Command
{
    private const COMMAND_NAME = 'robot:reset';

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
        $this->setName(self::COMMAND_NAME);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->robot->reset();

        return Command::SUCCESS;
    }
}
