<?php

declare(strict_types=1);

namespace Robot\Model\Robot;

interface RobotInterface
{
    public const MOVE_TYPE_PLACE = 'PLACE';
    public const MOVE_TYPE_MOVE = 'MOVE';

    public const MOVE_TYPES = [
        'PLACE',
        'MOVE'
    ];

    public const SIDE_TYPE_NORTH = 'NORTH';
    public const SIDE_TYPE_SOUTH = 'SOUTH';
    public const SIDE_TYPE_EAST = 'EAST';
    public const SIDE_TYPE_WEST = 'WEST';

    public const SIDE_TYPES = [
        self::SIDE_TYPE_NORTH,
        self::SIDE_TYPE_SOUTH,
        self::SIDE_TYPE_EAST,
        self::SIDE_TYPE_WEST
    ];

    /**
     * @param RobotPosition $robotPosition
     * @return $this
     */
    public function place(RobotPosition $robotPosition): self;
}
