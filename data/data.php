<?php
/**
 * Created by PhpStorm.
 * User: Jesse
 * Date: 4/6/2018
 * Time: 1:15 PM
 */

if(!class_exists("Dog"))
    require(__DIR__ . "/../models/dog.php");

if(!class_exists("Cat"))
    require(__DIR__ . "/../models/cat.php");

class DataAccessLayer
{
    private $mock;
    /* Mock data objects */
    private $tblDog = array();
    private $tblCat = array();
    /* database connection values */
    private $server;
    private $user;
    private $password;
    private $port;
    private $database;

    public function __construct($mock=true)
    {
        $this->mock = $mock;

        if($mock)
        {
            /* Throw a few test records into the "database" */
            $this->generateData();

            print "Connecting to database";
        }
        else
        {

        }
    }



    public function  beginTran(){
        print "Beginning a transaction";
    }

    public function commit() {
        print "Committing transaction";
    }

    public function rollback() {
        print "Rolling back transaction";
    }

    public function insert(string $table, $object) {
        print "Inserting " . $object->getName() . " into table " . $table;
    }

    /* Non-required stuff */

    public function select(string $table, string $field, $value) : array
    {
        /* guard against an object as a value */
        if(is_object($value))
            throw new Exception('Value may not be an object');
        
        $result = array();

        if($this->mock)
        {
            if(!property_exists(get_class($this), "tbl$table"))
                throw new Exception('Table tbl' . $table . ' does not exist');

            $result = $this->getRecordsFromDataset("tbl$table", $field, $value);

            return $result;
        }
        else
        {

        }
    }

    private function getRecordsFromDataset($intTable, $prop, $value) : array
    {
        if(!$this->mock)
        {
            return null;
        }

        $result = array();

        for($i=0 ; $i < sizeof($this->{$intTable}) ; $i++)
        {
            $tmp = 'get' . ucfirst($prop);

            if($this->{$intTable}[$i]->{'get' . ucfirst($prop)}() === $value || $value == '*')
            {
                array_push($result, $this->{$intTable}[$i]);
            }
        }

        return $result;
    }

    private function getRecordsFromDatabase($table, $column, $value) : array
    {
        if($this->mock)
        {
            return null;
        }


    }

    private static function PopulateObject($objIn, $objOut) : bool
    {
        try {
            $reflector = new ReflectionClass(get_class($objOut));
        }
        catch(Exception $ex)
        {
            //TODO: log
            return false;
        }

        foreach($objIn as $key => $value)
        {
            $property = $reflector->getProperty($key);

            if(!$property->isPrivate())
                $objOut->{$key} = $value;

        }

        return true;
    }

    private function generateData()
    {
        /* create dogs */
        $dog = new dog(14, "OldTimer", "Alpo");
        array_push($this->tblDog, $dog);
        $dog = new dog(5, "Fido", "Alpo");
        array_push($this->tblDog, $dog);

        /* create cats */
        $cat = new Cat(3, "Boots", "Purina");
        array_push($this->tblCat, $cat);
        $cat = new Cat(8, "Mr. Kit", "Friskies");
        array_push($this->tblCat, $cat);

    }
}