<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/6/2018
 * Time: 9:19 AM
 */

declare(strict_types=1);

interface iPet 
{
    /* required methods */
    public function getName() : string;
    public function getAge() : int;
    public function getFavoriteFood() : string;
    public function setName(string $petName) : void;
    public function setAge(int $petAge) : void;
    public function setFavoriteFood(string $petFood) : void;

    /* bonus coverage to show/test specific things */
    public function getTrinomialName() : string;
    public function getPetType() : string;
}