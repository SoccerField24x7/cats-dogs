<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/6/2018
 * Time: 9:48 AM
 */

declare(strict_types=1);

if(!interface_exists('iPet'))
    require(__DIR__ .'/../interfaces/ipet.php');

abstract class Pet implements iPet
{
    private $age;
    private $favoriteFood;
    protected $name;
    protected $IsDeleted = 0;
    protected $petTypeId = 0;
    public static $PETS = [0 => 'Unknown', 1 => 'Dog', 2 => 'Cat', 3 => 'Turtle', 4 => 'Bird', 5 => 'Unicorn'];

    public function __construct($Family, $Genus, $Species, $Subspecies, $petAge=0, $petName='', $petFood='')
    {
        $this->age = $petAge;
        $this->name = $petName;
        $this->favoriteFood = $petFood;
    }

    public function setAge(int $petAge) : void
    {
        $this->age = $petAge;
    }

    public function setFavoriteFood(string $petFood) : void
    {
        $this->favoriteFood = $petFood;
    }

    public function setName(string $petName) : void
    {
        $this->name = $petName;
    }

    public function setpetTypeId(int $petTypeId)
    {
        $this->petTypeId = $petTypeId;
    }

    public function getAge() : int
    {
        return $this->age;
    }

    public function getFavoriteFood() : string
    {
        return $this->favoriteFood;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getPetType(): string
    {
        return self::$PETS[$this->petTypeId];
    }

    public function getPetTypeId() : int
    {
        return $this->petTypeId;
    }

    abstract public static function toModel($obj);
    abstract public function getTrinomialName() : string;
}