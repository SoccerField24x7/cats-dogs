<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/6/2018
 * Time: 2:54 PM
 */

declare(strict_types=1);

require(__DIR__ . "/../data/data.php");

use PHPUnit\Framework\TestCase;

final class MockDataTest extends TestCase
{
    public function testCanMockBeCreated() : void
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

    public function testMockNumberOfDogRowsCorrectAge14() : void
    {
        $dal = new DataAccessLayer();
        $result = $dal->select("Dog", "age", "14");
        $this->assertEquals(1, sizeof($result));
    }

    public function testMockAddNewCatSuccess() : void
    {
        $cat = new Cat('Smudge', 15, 'Friskies');
        $dal = new DataAccessLayer();
        $this->assertEquals(true, $dal->insert('Cat', $cat));
    }

    public function testMockAddNewDogSuccess() : void
    {
        $dog = new Dog('Barkley', 5, 'Antelope');
        $dal = new DataAccessLayer();
        $dal->insert('Dog', $dog);
        $this->assertEquals(3, sizeof($dal->select('Dog', 'name', "*")));
    }

    public function testMockObjectMismatchFail() : void
    {
        $cat = new Cat(8, 'Kitty', 'Filet Mignon');
        $dal = new DataAccessLayer();
        $this->assertEquals(false, $dal->insert('Dog', $cat));
    }

}