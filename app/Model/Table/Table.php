<?php

declare(strict_types=1);

namespace Robot\Model\Table;

use Robot\Model\Robot\RobotPosition;

/**
 * Class Table
 * @package Robot\Model\Table
 */
class Table implements TableInterface
{
    private int $size;

    /**
     * Table constructor.
     * @param int $size
     */
    public function __construct(
        int $size
    ) {
        $this->size = $size;
    }

    /**
     * @param RobotPosition $robotPosition
     * @return bool
     */
    public function isValidPosition(RobotPosition $robotPosition): bool
    {
        if (
            $robotPosition->getX() > ($this->size - 1) ||
            $robotPosition->getY() > ($this->size - 1) ||
            $robotPosition->getX() < 0 ||
            $robotPosition->getY() < 0
        ) {
            return false;
        }

        return true;
    }
}
