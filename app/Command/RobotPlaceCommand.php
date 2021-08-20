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
class RobotPlaceCommand extends Command
{
    private const COMMAND_NAME = 'robot:place';
    private const ARGUMENT_PLACE_NAME = 'place';
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
            ->setDescription('Robot place')
            ->setHelp('Enabled move types: PLACE example: PLACE --x 0 --y 0 --facing NORTH')
            ->addArgument(
                self::ARGUMENT_PLACE_NAME,
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
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $robotMoveType = $input->getArgument(self::ARGUMENT_PLACE_NAME);

        $robotSideType = $input->getOption(self::OPTION_MOVE_NAME);
        $x = $input->getOption(self::OPTION_X_NAME);
        $y = $input->getOption(self::OPTION_Y_NAME);

        if (!in_array($robotSideType, RobotInterface::SIDE_TYPES, true)) {
            $output->writeln('Iam sorry, I cant do this. Check move type or word side type');

            return Command::FAILURE;
        }

        if ($robotMoveType === RobotInterface::MOVE_TYPE_PLACE) {
            try {
                $newPosition = RobotPositionFactory::create((int)$x, (int)$y, $robotSideType);

                $actualPosition = $this->robot->place($newPosition)->getActualPosition();
                $output->writeln('OUTPUT:' . $actualPosition->toString(true));
            } catch (\Exception $e) {
                $output->writeln($e->getMessage());
            }
        }
        return Command::SUCCESS;
    }
}
