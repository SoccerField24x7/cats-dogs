<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/6/2018
 * Time: 10:03 AM
 */
declare(strict_types=1);

require(__DIR__ . "/../models/cat.php");
require(__DIR__ . "/../models/dog.php");

use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{

    /* required tests */
    public function testRandomAgeBetween1and5()
    {

    }

    /* making sure everything works */
    public function testCanCatBeCreated(): void
    {
        $this->assertInstanceOf(
            Cat::class, new Cat()
        );
    }

    public function testCanDogBeCreated(): void
    {
        $this->assertInstanceOf(
            Dog::class, new Dog()
        );
    }

    public function testCatCorrectSpecies(): void
    {
        $cat = new Cat();
        $this->assertEquals(
            'Felis Silvestris Catus', $cat->GetTrinomialName()
        );
    }

    public function testDogCorrectSpecies(): void
    {
        $dog = new Dog();
        $this->assertEquals(
            'Canis Lupus Familiaris', $dog->GetTrinomialName()
        );
    }

    public function testCatAgeBeforeAfter(): void
    {
        $cat = new Cat();
        $this->assertEquals(0, $cat->getAge());
        $cat->setAge(12);
        $this->assertEquals(12, $cat->getAge());
    }
}