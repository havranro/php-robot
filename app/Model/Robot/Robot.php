<?php

declare(strict_types=1);

namespace Robot\Model\Robot;

use Exception;
use Robot\Model\Table\Table;
use Robot\Repository\PositionRepository;

class Robot implements RobotInterface
{
    private Table $table;

    private RobotPosition $actualPosition;

    /**
     * Robot constructor.
     * @param Table $table
     */
    public function __construct(
        Table $table
    )
    {
        $this->table = $table;
        $this->actualPosition = new RobotPosition();
    }

    /**
     * @return RobotPosition
     */
    public function getRobotPosition(): RobotPosition
    {
        return $this->actualPosition;
    }

    /**
     * @param RobotPosition $actualPosition
     * @throws Exception
     */
    public function setActualPosition(RobotPosition $actualPosition): void
    {
        PositionRepository::persist($actualPosition);

        $this->actualPosition = $actualPosition;
    }

    /**
     * @param RobotPosition $position
     * @return $this
     * @throws Exception
     */
    public function place(RobotPosition $position): self
    {
        if ($this->table->isValidPositionForPlace($position)) {
            $this->setActualPosition($position);

            return $this;
        }

        throw new Exception('This move is not valid, please provide valid x,y values');
    }

    /**
     * @param RobotPosition $to
     * @return $this
     * @throws Exception
     */
    public function move(RobotPosition $to): self
    {
        $actual = PositionRepository::getLastPosition();

        var_dump($actual);die();
    }
}
