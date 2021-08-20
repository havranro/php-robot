<?php

declare(strict_types=1);

namespace Robot\Model\Robot;

use MathPHP\LinearAlgebra\Vector;
use Robot\Repository\PositionRepository;

class RobotPosition
{
    public const SIDE_VECTORS = [
        [0, 1],
        [1, 0],
        [0, -1],
        [-1, 0],
    ];

    public const SIDE_TYPES_VECTOR_MAPPING = [
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
        $facing = ''
    ) {
        $this->x = $x;
        $this->y = $y;

        if (($facing !== '') && !is_array($facing)) {
            $this->facing = new Vector(self::SIDE_TYPES_VECTOR_MAPPING[$facing]);
        }

        if (is_array($facing)) {
            $this->facing = new Vector($facing);
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
     * @return null|string
     */
    public function getFacingAsString(): ?string
    {
        foreach (self::SIDE_TYPES_VECTOR_MAPPING as $char => $coords) {
            if ($coords === $this->getFacing()->getVector()) {
                return $char;
            }
        }

        return null;
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
            $this->setX($lastSavedPosition->getX());
            $this->setY($lastSavedPosition->getY());
            $this->setFacing($lastSavedPosition->getFacing());

            return true;
        } catch (\Exception $e) {
        }

        return false;
    }

    /**
     * @param bool $withFacing
     * @return string
     */
    public function toString(bool $withFacing = false): string
    {
        if ($withFacing) {
            return $this->getX() . ' ' . $this->getY() . ' ' . $this->getFacingAsString();
        }

        return $this->getX() . ' ' . $this->getY();
    }

    /**
     * @param int $size
     */
    public function moveNorth(int $size): void
    {
        $this->setY($this->getY() + $size);
    }

    /**
     * @param int $size
     */
    public function moveEast(int $size): void
    {
        $this->setX($this->getX() + $size);
    }

    /**
     * @param int $size
     */
    public function moveSouth(int $size): void
    {
        $this->setY($this->getY() - $size);
    }

    /**
     * @param int $size
     */
    public function moveWest(int $size): void
    {
        $this->setX($this->getX() - $size);
    }
}
