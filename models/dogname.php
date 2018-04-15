<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/15/2018
 * Time: 11:50 AM
 */

class DogName
{
    private $DogNameId = 0;
    private $DogId;
    private $Name;

    public function __construct(int $dogId, string $name)
    {
        $this->DogId = $dogId;
        $this->Name = $name;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getId()
    {
        return $this->DogId;
    }

    public function setName(string $name)
    {
        $this->Name = $name;
    }

    public function setDogId(int $id)
    {
        $this->DogId = $id;
    }

    public function setDogNameId(int $dogNameId)
    {
        $this->DogNameId = $dogNameId;
    }
}