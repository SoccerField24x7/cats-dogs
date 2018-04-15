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
    protected $age;
    private $favoriteFood;
    protected $name = array();
    protected $IsDeleted = 0;
    protected $petTypeId = 0;
    protected $speaks = 1;
    public static $PETS = [0 => 'Unknown', 1 => 'Dog', 2 => 'Cat', 3 => 'Turtle', 4 => 'Bird', 5 => 'Unicorn'];

    public function __construct($Family, $Genus, $Species, $Subspecies, $petAge=0, $petName='', $petFood='')
    {
        $this->age = $petAge;

        if($petName != '')
        {
            $this->setName($petName);
        }


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
        array_push($this->name, trim($petName));
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
        return sizeof($this->name) > 0 ? $this->name[count($this->name)-1] : '';  //count/sizeof the same, just showing I know...
    }

    public function getNames() : array
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

    //TODO: add guard logic to ensure
    public function getAverageNameLength() : int
    {
        /* find some fancier/lightning fast way to do this? */
        $total = 0;
        foreach($this->name as $name)
        {
            $total += strlen($name);
        }

        return (int)round($total / count($this->name), 0);
    }

    abstract public static function toModel($obj);
    abstract public function getTrinomialName() : string;
    abstract public function speak() : string;
}