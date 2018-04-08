<?php
/**
 * Created by PhpStorm.
 * User: Jesse Quijano
 * Date: 4/7/2018
 * Time: 8:52 AM
 */

declare(strict_types=1);

require(__DIR__ . "/../data/data.php");

use PHPUnit\Framework\TestCase;

final class DataTest extends TestCase
{

    private $server;
    private $user;
    private $password;
    private $database;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->server = 'localhost';
        $this->user = 'applelogin';
        $this->password = 'Letmeenter1!';
        $this->database = 'apple';
    }

    public function testCanDataLayerBeCreated() : void
    {
        $this->assertInstanceOf(
            DataAccessLayer::class, new DataAccessLayer(false, $this->server, $this->user, $this->password, $this->database)
        );
    }

    public function testCreateCatSuccess() : void
    {
        $dal = new DataAccessLayer(false, $this->server, $this->user, $this->password, $this->database);
        $cat = new Cat(2,'Meowth','Pizza');
        $this->assertEquals(true, $dal->insert('Cat', $cat));
    }

    public function testCreateDogSuccess() : void
    {
        $dal = new DataAccessLayer(false, $this->server, $this->user, $this->password, $this->database);
        $dog = new Dog(2,'Barkley','Mailmen');
        $this->assertEquals(true, $dal->insert('Dog', $dog));
    }

    public function testCreateDogPersistSuccess() : void
    {
        /* get total rows */
        $dal = new DataAccessLayer(false, $this->server, $this->user, $this->password, $this->database);
        $result = $dal->select('Dog', 'Name', "*");
        $beforeCount = sizeof($result);

        /* insert new */
        $dog = new Dog(8,'Rover','Alpo');
        $dal->insert('Dog', $dog);

        /* make sure s'all good */
        $result = $dal->select('Dog', 'Name', "*");

        $this->assertTrue(sizeof($result) > $beforeCount);
    }

    public function testCreateCatPersistSuccess() : void
    {
        /* get total rows */
        $dal = new DataAccessLayer(false, $this->server, $this->user, $this->password, $this->database);
        $result = $dal->select('Cat', 'Name', "*");
        $beforeCount = sizeof($result);

        /* insert new */
        $cat = new Cat(7,'Whiskers','Iams');
        $dal->insert('Cat', $cat);

        /* make sure s'all good */
        $result = $dal->select('Cat', 'Name', "*");

        $this->assertTrue(sizeof($result) > $beforeCount);
    }
}