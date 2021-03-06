<?php

declare(strict_types=1);

namespace Robot\Model\Robot;

use Exception;

/**
 * Interface RobotInterface
 * @package Robot\Model\Robot
 */
interface RobotInterface
{
    public const MOVE_TYPE_PLACE = 'PLACE';

    public const SIDE_TYPE_NORTH = 'NORTH';
    public const SIDE_TYPE_SOUTH = 'SOUTH';
    public const SIDE_TYPE_EAST = 'EAST';
    public const SIDE_TYPE_WEST = 'WEST';

    public const SIDE_TYPES = [
        self::SIDE_TYPE_NORTH,
        self::SIDE_TYPE_EAST,
        self::SIDE_TYPE_SOUTH,
        self::SIDE_TYPE_WEST
    ];

    public const FACING_TYPE_LEFT = 'LEFT';
    public const FACING_TYPE_RIGHT = 'RIGHT';

    public const FACING_TYPES = [
        self::FACING_TYPE_LEFT,
        self::FACING_TYPE_RIGHT
    ];

    /**
     * Place robot on some table X,Y
     *
     * @param RobotPosition $position
     * @return $this
     * @throws Exception
     */
    public function place(RobotPosition $position): self;

    /**
     * Move with Robot in select pixel size
     *
     * @param int $moveSize
     * @return $this
     * @throws Exception
     */
    public function move(int $moveSize): self;

    /**
     * Changing facing or robot (LEFT,RIGHT)
     *
     * @param string $facing
     * @return $this
     * @throws Exception
     */
    public function changeFacing(string $facing): self;

    /**
     * Method reset saved last position of robot
     */
    public function reset(): void;
}
