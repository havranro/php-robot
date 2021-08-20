<?php

declare(strict_types=1);

namespace Robot\Repository;

use Exception;
use JsonException;
use Nette\Utils\FileSystem;
use Robot\Model\Robot\RobotPosition;

class PositionRepository
{
    private const FILE_PATH_TO_PERSIST = __DIR__ . '/../../temp/robot.txt';

    /**
     * @return array
     * @throws Exception
     */
    public static function getLastPosition(): array
    {
        try {
            return json_decode(FileSystem::read(self::FILE_PATH_TO_PERSIST), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new Exception('Filesystem cant read file');
        }
    }

    /**
     * @param RobotPosition $robotPosition
     * @throws Exception
     */
    public static function persist(RobotPosition $robotPosition): void
    {
        $position = [
            $robotPosition->getX(),
            $robotPosition->getY(),
            $robotPosition->getFacingAsString()
        ];

        try {
            FileSystem::write(self::FILE_PATH_TO_PERSIST, json_encode($position, JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            throw new Exception('Filesystem cant write to file');
        }
    }
}
