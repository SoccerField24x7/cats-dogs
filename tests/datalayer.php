<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/6/2018
 * Time: 2:54 PM
 */

declare(strict_types=1);

require(__DIR__ . "/../data/data.php");
//require(__DIR__ . "/../models/cat.php");
//require(__DIR__ . "/../models/dog.php");

use PHPUnit\Framework\TestCase;

final class DataTest extends TestCase
{
    public function testCanCatBeCreated() : void
    {
        $this->assertInstanceOf(
            DataAccessLayer::class, new DataAccessLayer()
        );
    }

    public function testMockBadTableThrowsException() : void
    {
        $dal = new DataAccessLayer();

        $this->expectException(Exception::class);

        $result = $dal->select("Unicorns", "should", "fail");
    }

    public function testMockNumberOfCatRowsCorrectBoots() : void
    {
        $dal = new DataAccessLayer();
        $result = $dal->select("Cat", "name", "Boots");
        $this->assertEquals(1, sizeof($result));
    }

    public function testMockNumberOfDogRowsCorrectAll() : void
    {
        $dal = new DataAccessLayer();
        $result = $dal->select("Dog", "name", "*");
        $this->assertEquals(2, sizeof($result));
    }

    public function testMockNumberOfDogRowsCorrectAlpo() : void
    {
        $dal = new DataAccessLayer();
        $result = $dal->select("Dog", "favoriteFood", "Alpo");
        $this->assertEquals(2, sizeof($result));
    }

    public function testMockNumberOfCatRowsCorrectFriskies() : void
    {
        $dal = new DataAccessLayer();
        $result = $dal->select("Cat", "favoriteFood", "Friskies");
        $this->assertEquals(1, sizeof($result));
    }

}