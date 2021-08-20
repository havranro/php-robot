<?php

declare(strict_types=1);

namespace Robot\Factory;

use Robot\Model\Robot\RobotPosition;

class RobotPositionFactory
{
    /**
     * @param int $x
     * @param int $y
     * @param $facing
     * @return RobotPosition
     */
    public static function create(int $x = null, int $y = null, $facing = ''): RobotPosition
    {
        return new RobotPosition($x, $y, $facing);
    }
}
