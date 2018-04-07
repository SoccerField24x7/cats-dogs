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

    public function __construct(int $petAge = 0, string $petName = '', string $petFood = '')
    {
        parent::__construct($this->Family, $this->Genus, $this->Species, $this->Subspecies, $petAge, $petName, $petFood);
        $this->petType = 1;
    }

    public function getTriNomialName() : string
    {
        return $this->Genus . ' ' . $this->Species . ' ' . $this->Subspecies;
    }
}