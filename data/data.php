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

    public function __construct($mock=true, $server='localhost', $user='user', $password='pas', $database='db', $port=3306)
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

            print "Connecting to database";
        }
        else
        {
            if(!$this->validDBCredentials())
                throw new Exception('Invalid database credentials');

            if(!$this->connecctDB())
                throw new Exception('Database connection could not be established.');
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
            print "Inserting " . $object->getName() . " into table " . $table;
            array_push($this->{'tbl' . $table}, $object);
        }
        else
        {
            //TODO: implement
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

    private function connectDB() : bool
    {
        try {
            $conn = new PDO("mysql:host=$this->server;dbname=$this->database", $this->user, $this->password);
            if (!$conn) {
                return false;
            }

            $this->conn = $conn;

        } catch(Exception $ex) {
            //TODO: figure out how to raise this
            return false;
        }
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
        $sql = $value == '*' ? "SELECT * FROM $table WHERE": "SELECT * FROM $table WHERE $column='$value'";

        $data = $this->query($sql);
        if($this->conn->errorCode() != '00000')
        {
            return $result;
        }

        $result = $data->fetchAlll(PDO::FETCH_OBJ);

        return $result;
    }

    /*private static function PopulateObject($objIn, $objOut) : bool
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
    }*/

    private function generateMockData()
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