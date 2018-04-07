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


    public function __construct(int $petAge = 0, string $petName = '', string $petFood = '')
    {
        parent::__construct($this->Family, $this->Genus, $this->Species, $this->Subspecies, $petAge, $petName, $petFood);
        $this->petType = 2;
    }

    public function getTriNomialName() : string
    {
        return $this->Genus . ' ' . $this->Species . ' ' . $this->Subspecies;
    }

}