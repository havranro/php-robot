<?php

declare(strict_types=1);

namespace Robot\Model\Robot;

use Exception;
use MathPHP\LinearAlgebra\Vector;
use Robot\Model\Table\Table;
use Robot\Repository\PositionRepository;

/**
 * Class Robot
 * @package Robot\Model\Robot
 */
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
    ) {
        $this->table = $table;
        $this->actualPosition = new RobotPosition();
    }

    /**
     * @param RobotPosition $position
     * @return $this
     * @throws Exception
     */
    public function place(RobotPosition $position): self
    {
        if ($this->table->isValidPosition($position)) {
            $this->setActualPosition($position);

            return $this;
        }

        throw new Exception('This move is not valid, please provide valid x,y values');
    }

    /**
     * @param int $moveSize
     * @return $this
     * @throws Exception
     */
    public function move(int $moveSize): self
    {
        $from = $this->getLastPosition();

        $facing = $from->getFacingAsString();

        if ($facing === self::SIDE_TYPE_NORTH) {
            $from->moveNorth($moveSize);
        } else {
            if ($facing === self::SIDE_TYPE_WEST) {
                $from->moveWest($moveSize);
            } else {
                if ($facing === self::SIDE_TYPE_SOUTH) {
                    $from->moveSouth($moveSize);
                } else {
                    $from->moveEast($moveSize);
                }
            }
        }

        if (!$this->table->isValidPosition($from)) {
            throw new Exception('Out of table range.');
        }

        $this->setActualPosition($from);

        return $this;
    }

    /**
     * @param string $facing
     * @return $this
     * @throws Exception
     */
    public function changeFacing(string $facing): self
    {
        $lastPosition = $this->getLastPosition();

        $keySideFacing = array_search($lastPosition->getFacing()->getVector(), RobotPosition::SIDE_VECTORS, true);

        // TOTO I'm sorry, but I didn't find a better solution and I didn't come up with a better one :(
        if ($facing === self::FACING_TYPE_RIGHT) {
            if (isset(RobotPosition::SIDE_VECTORS[$keySideFacing + 1])) {
                $lastPosition->setFacing(new Vector(RobotPosition::SIDE_VECTORS[$keySideFacing + 1]));
            } else {
                $lastPosition->setFacing(new Vector(RobotPosition::SIDE_VECTORS[0]));
            }
        }

        if ($facing === self::FACING_TYPE_LEFT) {
            if (isset(RobotPosition::SIDE_VECTORS[$keySideFacing - 1])) {
                $lastPosition->setFacing(new Vector(RobotPosition::SIDE_VECTORS[$keySideFacing - 1]));
            } else {
                $lastPosition->setFacing(new Vector(RobotPosition::SIDE_VECTORS[3]));
            }
        }

        $this->setActualPosition($lastPosition);

        return $this;
    }

    /**
     * @return RobotPosition
     */
    public function getActualPosition(): RobotPosition
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
     * @return RobotPosition
     * @throws Exception
     */
    private function getLastPosition(): RobotPosition
    {
        return PositionRepository::getLastPosition();
    }
}
