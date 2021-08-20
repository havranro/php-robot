<?php

declare(strict_types=1);

namespace Robot\Factory;

use MathPHP\Exception\BadDataException;
use Robot\Model\Robot\RobotPosition;

/**
 * Class RobotPositionFactory
 * @package Robot\Factory
 */
class RobotPositionFactory
{
    /**
     * @param int|null $x
     * @param int|null $y
     * @param string $facing
     * @return RobotPosition
     * @throws BadDataException
     */
    public static function create(int $x = null, int $y = null, $facing = ''): RobotPosition
    {
        return new RobotPosition($x, $y, $facing);
    }
}
