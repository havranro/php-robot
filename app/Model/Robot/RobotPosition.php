<?php

declare(strict_types=1);

namespace Robot\Model\Robot;

use MathPHP\LinearAlgebra\Vector;
use Robot\Repository\PositionRepository;

class RobotPosition
{
    private const SIDE_TYPES_VECTOR_MAPPING = [
        RobotInterface::SIDE_TYPE_NORTH => [0, 1],
        RobotInterface::SIDE_TYPE_EAST => [1, 0],
        RobotInterface::SIDE_TYPE_SOUTH => [0, -1],
        RobotInterface::SIDE_TYPE_WEST => [-1, 0],
    ];

    private ?int $x;

    private ?int $y;

    private ?Vector $facing;

    public function __construct(
        int $x = null,
        int $y = null,
        string $facing = ''
    ) {
        $this->x = $x;
        $this->y = $y;

        if ($facing !== '') {
            $this->facing = new Vector(self::SIDE_TYPES_VECTOR_MAPPING[$facing]);
        }
    }

    /**
     * @return int|null
     */
    public function getX(): ?int
    {
        return $this->x;
    }

    /**
     * @param int|null $x
     */
    public function setX(?int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int|null
     */
    public function getY(): ?int
    {
        return $this->y;
    }

    /**
     * @param int|null $y
     */
    public function setY(?int $y): void
    {
        $this->y = $y;
    }

    /**
     * @return Vector|null
     */
    public function getFacing(): ?Vector
    {
        return $this->facing;
    }

    /**
     * @param Vector|null $facing
     */
    public function setFacing(?Vector $facing): void
    {
        $this->facing = $facing;
    }

    /**
     * @return string
     */
    public function getFacingAsString(): string
    {
        foreach (self::SIDE_TYPES_VECTOR_MAPPING as $char => $coords) {
            if ($coords === $this->getFacing()->getVector()) {
                return $char;
            }
        }
    }

    /**
     * @return bool
     */
    public function isPositionSetted(): bool
    {
        if (!is_null($this->getX()) && !is_null($this->getY()) && !is_null($this->getFacing())) {
            return true;
        }

        try {
            $lastSavedPosition = PositionRepository::getLastPosition();
            $this->setX($lastSavedPosition[0]);
            $this->setY($lastSavedPosition[1]);
            $this->setFacing(new Vector(self::SIDE_TYPES_VECTOR_MAPPING[$lastSavedPosition[2]]));

            return true;
        } catch (\Exception $e) {
        }

        return false;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->getX() . ' ' . $this->getY() . ' ' . $this->getFacingAsString();
    }
}
