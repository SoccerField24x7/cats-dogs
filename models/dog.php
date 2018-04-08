<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/6/2018
 * Time: 1:05 PM
 */

if(!class_exists('Pet'))
    require(__DIR__ . '/../templates/basepet.php');

Class Dog extends Pet
{
    private $Family = "Canidae";
    private $Genus = "Canis";
    private $Species = "Lupus";
    private $Subspecies = "Familiaris";
    private $DogId = 0;

    public function __construct(int $petAge = 0, string $petName = '', string $petFood = '')
    {
        parent::__construct($this->Family, $this->Genus, $this->Species, $this->Subspecies, $petAge, $petName, $petFood);
        $this->petTypeId = 1;
    }

    public function getTriNomialName() : string
    {
        return $this->Genus . ' ' . $this->Species . ' ' . $this->Subspecies;
    }

    public function setId(int $petId) : void
    {
        $this->DogId = $petId;
    }

    public function getId() : int
    {
        return $this->DogId;
    }

    public static function toModel($obj)
    {
        if(!is_object($obj))
        {
            return null;
        }

        $dog = new Dog();

        try
        {
            $dog->setName($obj->getName());
            $dog->setFavoriteFood($obj->getFavoriteFood);
            $dog->setAge($obj->getAge());
            $dog->setId($obj->getId());
            $dog->setpetTypeId(1);
        }
        catch (Exception $ex)
        {
            throw new Exception($ex->getMessage());
        }

        return $dog;
    }
}