<?php

declare(strict_types=1);

namespace Robot\Model\Table;

use Robot\Model\Robot\RobotPosition;

/**
 * Interface TableInterface
 * @package Robot\Model\Table
 */
interface TableInterface
{
    /**
     * Method check if robot position is valid
     *
     * @param RobotPosition $robotPosition
     * @return bool
     */
    public function isValidPosition(RobotPosition $robotPosition): bool;
}
