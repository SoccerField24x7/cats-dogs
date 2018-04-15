<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/6/2018
 * Time: 1:05 PM
 */

if(!class_exists('Pet'))
    require(__DIR__ . '/../templates/basepet.php');

class Cat extends Pet
{

    private $Family = "Felidae";
    private $Genus = "Felis";
    private $Species = "Silvestris";
    private $Subspecies = "Catus";
    private $CatId = 0;

    public function __construct(string $petName = '', int $petAge = 0, string $petFood = '')
    {
        parent::__construct($this->Family, $this->Genus, $this->Species, $this->Subspecies, $petAge, $petName, $petFood);
        $this->petTypeId = 2;
    }

    public function getTriNomialName() : string
    {
        return $this->Genus . ' ' . $this->Species . ' ' . $this->Subspecies;
    }

    public function setId(int $petId) : void
    {
        $this->CatId = $petId;
    }

    public function getId() : int
    {
        return $this->CatId;
    }

    public static function toModel($obj)
    {
        if(!is_object($obj))
        {
            return null;
        }

        $cat = new Cat();

        try
        {
            $cat->setName($obj->Name);
            $cat->setFavoriteFood($obj->FavoriteFood);
            $cat->setAge($obj->Age);
            $cat->setId($obj->CatId);
            $cat->setpetTypeId(2);
        }
        catch (Exception $ex)
        {
            throw new Exception($ex->getMessage());
        }

        return $cat;
    }

    public function speak($sound="Meow") : string
    {
        /* because of a strange genetic disease, cats actually age when speaking */
        if($this->speaks++ % 5 == 0)
            $this->age++;

        return $sound;
    }
}