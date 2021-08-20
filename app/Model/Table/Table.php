<?php

declare(strict_types=1);

namespace Robot\Model\Table;

use MathPHP\LinearAlgebra\Vector;
use Robot\Model\Robot\RobotPosition;

class Table implements TableInterface
{
    private int $size;

    /**
     * Table constructor.
     * @param int $size
     */
    public function __construct(
        int $size
    )
    {
        $this->size = $size;
    }

    /**
     * @param RobotPosition $robotPosition
     * @return bool
     */
    public function isValidPositionForPlace(RobotPosition $robotPosition): bool
    {
        if ((abs($robotPosition->getX()) > $this->size) || abs($robotPosition->getY()) > $this->size) {
            return false;
        }

        return true;
    }

    public function validateDimensionality(Vector ...$vectors): void
    {
        $tableDimensions = $this->size;

        array_walk(
            $vectors,
            function (Vector $vector) use ($tableDimensions) {
                if ($vector->getN() !== $tableDimensions) {
                    $errorMsg = sprintf(
                        'There is a position that has [%d] dimensions but space has [%d] dimensions',
                        $vector->getN(),
                        $tableDimensions
                    );

                    throw new \Exception($errorMsg);
                }
            }
        );
    }
}
