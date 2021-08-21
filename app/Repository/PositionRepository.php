<?php

declare(strict_types=1);

namespace Robot\Repository;

use Exception;
use JsonException;
use Nette\Utils\FileSystem;
use Robot\Factory\RobotPositionFactory;
use Robot\Model\Robot\RobotPosition;

/**
 * Class PositionRepository
 * @package Robot\Repository
 */
class PositionRepository
{
    private const FILE_PATH_TO_PERSIST = __DIR__ . '/../../temp/robot.txt';

    /**
     * @return RobotPosition
     * @throws Exception
     */
    public static function getLastPosition(): RobotPosition
    {
        try {
            $data = json_decode(FileSystem::read(self::FILE_PATH_TO_PERSIST), true, 512, JSON_THROW_ON_ERROR);

            return RobotPositionFactory::create($data[0], $data[1], $data[2]);
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
            $robotPosition->getFacing()
        ];

        try {
            FileSystem::write(self::FILE_PATH_TO_PERSIST, json_encode($position, JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            throw new Exception('Filesystem cant write to file');
        }
    }

    public static function remove(): void
    {
        FileSystem::write(self::FILE_PATH_TO_PERSIST, '');
    }
}
