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
    private $models = array('Cat', 'Dog');
    /* database connection values */
    private $server;
    private $user;
    private $password;
    private $port;
    private $database;
    private $conn;

    public function __construct($mock=true, $server='localhost', $user='user', $password='pass', $database='db', $port=3306)
    {
        /* accept inbound parameters */
        $this->mock = $mock;
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->port = $port;
        $this->database = $database;

        if($mock)
        {
            /* Throw a few base test records into the "database" */
            $this->generateMockData();

            print "Connecting to database" . PHP_EOL;
        }
        else
        {
            if(!$this->validDBCredentials())
                throw new Exception('Invalid database credentials');

            if(!$this->connectDB())
                throw new Exception('Database connection could not be established.');
        }
    }

    public function  beginTran(){
        print "Beginning a transaction" . PHP_EOL;
    }

    public function commit() {
        print "Committing transaction" . PHP_EOL;
    }

    public function rollback() {
        print "Rolling back transaction" . PHP_EOL;
    }

    public function insert(string $table, $object) : bool
    {
        if(!$this->validModel($table))
            throw new Exception('Invalid table specified.');

        if(!is_object($object))
            return false;  //TODO: decide if exception or return false is best

        /* in the interest of time, simple validation */
        $objClass = get_class($object);
        if(!$this->validModel($objClass))
            return false;

        /* last make sure you're not trying to store the wrong object in the wrong table */
        if($table != $objClass)
            return false;

        if($this->mock)
        {
            print "Inserting " . $object->getName() . " into table " . $table . PHP_EOL;
            $object->setId($this->getNextId($table));
            array_push($this->{'tbl' . $table}, $object);
        }
        else
        {
            $sql = "INSERT INTO $table (PetTypeId, Age, FavoriteFood, `Name`)VALUES(" . $object->getPetTypeId() . "," . $object->getAge() . "," . $this->conn->quote($object->getFavoriteFood()) . "," . $this->conn->quote($object->getName()) . ")";
            $this->conn->query($sql);
            if($this->conn->errorCode() != '00000')
            {
                $err = $this->conn->errorInfo();
                throw new Exception($err[2]);
            }
        }

        return true;
    }

    /* Non-required stuff */

    public function select(string $table, string $field, $value) : array
    {
        /* guard against an object as a value */
        if(is_object($value))
            throw new Exception('Value may not be an object');

        if(!$this->validModel($table))
            throw new Exception('Invalid table specified.');
        
        $result = array();

        if($this->mock)
        {
            if(!property_exists(get_class($this), "tbl$table"))
                throw new Exception('Table tbl' . $table . ' does not exist');

            $result = $this->getRecordsFromDataset("tbl$table", $field, $value);

            //note: no test for null because it won't be possible from here

        }
        else
        {
            $result = $this->getRecordsFromDatabase($table, $field, $value);
        }

        return $result;
    }

    private function getNextId(string $model)
    {
        return sizeof($this->{'tbl' . $model});
    }

    private function connectDB() : bool
    {
        try {
            $conn = new PDO("mysql:host=$this->server;dbname=$this->database", $this->user, $this->password);
            if (!$conn) {
                return false;
            }

            $this->conn = $conn;

        } catch(Exception $ex) {
            //TODO: decide if/how to raise this
            return false;
        }

        return true;
    }

    private function validDBCredentials() : bool
    {
        if($this->user == 'user' || $this->password == 'pass' || $this->database == 'db')
            return false;

        return true;
    }

    private function validModel(string $table) : bool
    {
        return in_array($table, $this->models);
    }

    private function getRecordsFromDataset($intTable, $prop, $value) : array
    {
        if(!$this->mock) //fail-safe for future developers that may use this method
        {
            return null;
        }

        //force numeric type. Not infallible, but will do in the interest of time.
        $value = is_numeric($value) ? (int)$value : $value;

        $result = array();

        for($i=0 ; $i < sizeof($this->{$intTable}) ; $i++)
        {
            /* if get() or * specified */
            if($this->{$intTable}[$i]->{'get' . ucfirst($prop)}() === $value || $value == '*')
            {
                array_push($result, $this->{$intTable}[$i]);
            }
        }

        return $result;
    }

    private function getRecordsFromDatabase($table, $column, $value) : array
    {
        if($this->mock)  //fail-safe for future developers that may use this method
        {
            return null;
        }

        $result = array();
        $sql = $value == '*' ? "SELECT * FROM $table": "SELECT * FROM $table WHERE $column='$value'";

        $data = $this->conn->query($sql);
        if($this->conn->errorCode() != '00000')
        {
            return $result;
        }

        $result = $data->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $row)
        {
            $obj = null;
            try
            {
                $obj = $table == 'Cat' ? Cat::toModel($row) : Dog::toModel($row);
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
            array_push($result, $obj);
        }

        return $result;
    }

    private function generateMockData()
    {
        /* create dogs */
        $dog = new dog("OldTimer", 14, "Alpo");
        $this->insert(get_class($dog), $dog);
        $dog = new dog("Fido", 5, "Alpo");
        $this->insert(get_class($dog), $dog);

        /* create cats */
        $cat = new Cat("Boots", 3, "Purina");
        $this->insert(get_class($cat), $cat);
        $cat = new Cat("Mr. Kit", 8, "Friskies");
        $this->insert(get_class($cat), $cat);

    }
}