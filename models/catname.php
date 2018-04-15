<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/15/2018
 * Time: 3:48 PM
 */

class CatName
{
    private $CatNameId = 0;
    private $CatId;
    private $Name;

    public function __construct(int $catId, string $name)
    {
        $this->CatId = $catId;
        $this->Name = $name;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getId()
    {
        return $this->CatId;
    }

    public function setName(string $name)
    {
        $this->Name = $name;
    }

    public function setCatId(int $id)
    {
        $this->CatId = $id;
    }

    public function setCatNameId(int $catNameId)
    {
        $this->CatNameId = $catNameId;
    }
}