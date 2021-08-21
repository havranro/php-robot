<?php

use Codeception\Test\Unit;
use Robot\Model\Robot\Robot;
use Robot\Model\Robot\RobotPosition;

class RobotTest extends Unit
{
    /**
     * @var Robot
     */
    private $testedClass;

    protected function _before()
    {
        // testing for 5x5
        $table = new \Robot\Model\Table\Table(5);
        $this->testedClass = new Robot($table);
    }

    protected function _after()
    {

    }

    public function testPlace()
    {
        // reset robot positions
        $this->testedClass->reset();

        $x = 0;
        $y = 0;
        $facing = 'NORTH';

        $newPosition = new RobotPosition($x, $y, $facing);
        $this->testedClass->place($newPosition);

        // after place robot must be on 0,0 NORTH
        // test for X
        $this->assertEquals(0, $this->testedClass->getActualPosition()->getX());
        // test for Y
        $this->assertEquals(0, $this->testedClass->getActualPosition()->getY());
        // test for facing
        $this->assertEquals('NORTH', $this->testedClass->getActualPosition()->getFacingAsString());

        $x = 1;
        $y = 4;
        $facing = 'WEST';

        $newPosition = new RobotPosition($x, $y, $facing);
        $this->testedClass->place($newPosition);

        // after place robot must be on 1,4 WEST
        // test for X
        $this->assertEquals(1, $this->testedClass->getActualPosition()->getX());
        // test for Y
        $this->assertEquals(4, $this->testedClass->getActualPosition()->getY());
        // test for facing
        $this->assertEquals('WEST', $this->testedClass->getActualPosition()->getFacingAsString());


        $x = 12321313;
        $y = 1;
        $facing = 'EAST';

        // after place robot must be throwed exception - bad X,Y
        $newPosition = new RobotPosition($x, $y, $facing);

        try {
            $placedRobot = $this->testedClass->place($newPosition);
        } catch (Exception $e) {
            $placedRobot = $e;
        }

        $this->assertTrue($placedRobot instanceof Exception);
    }

    public function testChangeFacing()
    {
        // starts without placed robot
        $this->testedClass->reset();

        // move size 1
        try {
            $movedRobot = $this->testedClass->move(1);
        } catch (Exception $e) {
            $movedRobot = $e;
        }

        // Exception because robot is not placed
        $this->assertTrue($movedRobot instanceof Exception);

        $x = 0;
        $y = 0;
        $facing = 'NORTH';

        $robotPosition = new RobotPosition($x, $y, $facing);

        $this->testedClass->place($robotPosition);

        $this->testedClass->changeFacing('RIGHT');
        $this->assertEquals('EAST', $this->testedClass->getActualPosition()->getFacingAsString());
        $this->testedClass->changeFacing('RIGHT');
        $this->assertEquals('SOUTH', $this->testedClass->getActualPosition()->getFacingAsString());
        $this->testedClass->changeFacing('RIGHT');
        $this->assertEquals('WEST', $this->testedClass->getActualPosition()->getFacingAsString());
        $this->testedClass->changeFacing('RIGHT');
        $this->assertEquals('NORTH', $this->testedClass->getActualPosition()->getFacingAsString());

        $this->testedClass->changeFacing('LEFT');
        $this->assertEquals('WEST', $this->testedClass->getActualPosition()->getFacingAsString());
        $this->testedClass->changeFacing('LEFT');
        $this->assertEquals('SOUTH', $this->testedClass->getActualPosition()->getFacingAsString());
        $this->testedClass->changeFacing('LEFT');
        $this->assertEquals('EAST', $this->testedClass->getActualPosition()->getFacingAsString());
        $this->testedClass->changeFacing('LEFT');
        $this->assertEquals('NORTH', $this->testedClass->getActualPosition()->getFacingAsString());

        $this->testedClass->changeFacing('LEFT');
        $this->assertEquals('WEST', $this->testedClass->getActualPosition()->getFacingAsString());

        $this->testedClass->changeFacing('RIGHT');
        $this->assertEquals('NORTH', $this->testedClass->getActualPosition()->getFacingAsString());

        $this->testedClass->changeFacing('EAST');
        $this->assertEquals('NORTH', $this->testedClass->getActualPosition()->getFacingAsString());

    }

    public function testMove()
    {
        // starts without placed robot
        $this->testedClass->reset();

        // move size 1
        try {
            $movedRobot = $this->testedClass->move(1);
        } catch (Exception $e) {
            $movedRobot = $e;
        }

        // Exception because robot is not placed
        $this->assertTrue($movedRobot instanceof Exception);

        $x = 0;
        $y = 0;
        $facing = 'NORTH';

        $robotPosition = new RobotPosition($x, $y, $facing);

        $this->testedClass->place($robotPosition);

        $this->testedClass->move(1);

        $this->assertEquals(0, $this->testedClass->getActualPosition()->getX());
        $this->assertEquals(1, $this->testedClass->getActualPosition()->getY());
        $this->assertEquals('NORTH', $this->testedClass->getActualPosition()->getFacingAsString());

        $this->testedClass->move(1);

        $this->assertEquals(0, $this->testedClass->getActualPosition()->getX());
        $this->assertEquals(2, $this->testedClass->getActualPosition()->getY());
        $this->assertEquals('NORTH', $this->testedClass->getActualPosition()->getFacingAsString());

        // This move must throw exception out of table range
        try {
            $result = $this->testedClass->move(3);
        } catch (Exception $e) {
            $result = $e;
        }

        $this->assertTrue($result instanceof Exception);

        // Test move with changed facing
        $this->testedClass->changeFacing('RIGHT');
        $this->testedClass->move(1);

        $this->assertEquals(1, $this->testedClass->getActualPosition()->getX());
        $this->assertEquals(2, $this->testedClass->getActualPosition()->getY());
        $this->assertEquals('EAST', $this->testedClass->getActualPosition()->getFacingAsString());

        $this->testedClass->changeFacing('RIGHT');
        $this->testedClass->move(1);

        $this->assertEquals(1, $this->testedClass->getActualPosition()->getX());
        $this->assertEquals(1, $this->testedClass->getActualPosition()->getY());
        $this->assertEquals('SOUTH', $this->testedClass->getActualPosition()->getFacingAsString());

        $this->testedClass->move(1);
        $this->testedClass->changeFacing('RIGHT');
        $this->testedClass->move(1);

        $this->assertEquals(0, $this->testedClass->getActualPosition()->getX());
        $this->assertEquals(0, $this->testedClass->getActualPosition()->getY());
        $this->assertEquals('WEST', $this->testedClass->getActualPosition()->getFacingAsString());

    }
}
