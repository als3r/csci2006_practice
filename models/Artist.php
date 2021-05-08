<?php
require_once 'Model.php';

/**
 * Class Artist
 * Extends Model
 *
 * Handles interactions with a record of the artist
 */
class Artist extends Model
{
    static $enittyName = "Artist";
    static $table      = "Artist";
    static $table_id   = "artist_id";

    /**
     * Artist ID of the artwork
     * @var integer
     */
    private $artist_id;

    /**
     * Artist Full Name
     * @var string
     */
    private $artist_fullName;

    /*
     * Last Name
     * @var string
     */
    private $artist_lastName;

    /*
     * Artist Year of the birth
     * @var string
     */
    private $artist_born;

    /*
     * Artist Year of the death
     * @var string
     */
    private $artist_died;

    /*
     * Artist Origin
     * @var string
     */
    private $artist_origin;

    /*
     * Aritst Influence
     * @var string
     */
    private $artist_influence;

    /*
     * Artist Description
     * @var string
     */
    private $artist_desc;


    // Default Data for a record
    private const DEFAULT_DATA = [
        "artist_id"        => null,
        "artist_fullName"  => "",
        "artist_lastName"  => "",
        "artist_born"      => 0,
        "artist_died"      => 0,
        "artist_origin"    => "",
        "artist_influence" => "",
        "artist_desc"      => "",
    ];


    /**
     * Artist constructor.
     *
     * Loads artist record by id
     *
     * @param $id
     */
    public function __construct($id = 0, $pdo = null)
    {
        parent::__construct($id);
        if($pdo){
            $this->setPdoDb($pdo);
        }
        $this->loadData($id);
    }


    /**
     * Load data into model
     *
     * @param int $id
     * @return bool
     */
    public function loadData($id = 0)
    {
        $arr = $this->getData($id);
        if (!$arr) {
            $this->log("Could Not Retrieve ID: " . (int) $id);
            return false;
        }

        if( isset(
            $arr["artist_id"],
            $arr["artist_fullName"],
            $arr["artist_lastName"],
            $arr["artist_born"],
            $arr["artist_died"],
            $arr["artist_origin"],
            $arr["artist_influence"],
            $arr["artist_desc"]
        )) {
            $this->setId(         $arr["artist_id"]);
            $this->setFullName(   $arr["artist_fullName"]);
            $this->setLastName(   $arr["artist_lastName"]);
            $this->setBorn(       $arr["artist_born"]);
            $this->setDied(       $arr["artist_died"]);
            $this->setOrigin(     $arr["artist_origin"]);
            $this->setInfluence(  $arr["artist_influence"]);
            $this->setDescription($arr["artist_desc"]);
        }
        $this->log("Retrieved Object: (type: Artist, id: ".(int) $id.")" . $this->toString());
        return true;
    }


    /**
     * Get a record (array) from Data array By ID
     *
     * @param int $id
     * @return array
     */
    public function getData($id = 0)
    {
        $record = $this->retrieveOneById($id);
        if ($record) {
            return $record;
        } else {
            return self::DEFAULT_DATA;
        }
    }


    /**
     * Get id => full name pairs for all Artists
     *
     * @param $pdo
     * @return mixed
     */
    public static function getAll($pdo){

        $stmt = $pdo->prepare('SELECT artist_id as id, artist_fullName as name
                FROM  ' . self::$table)
        ;
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Create a record of artist
     *
     * @return mixed|void
     */
    public function create()
    {
        $this->log("Start. Create ".self::$enittyName);
        if($this->getPdoDb() !== null){
            $stmt = $this->getPdoDb()->prepare('INSERT INTO ' . self::$table    . '
                (
                    artist_id,
                    artist_fullName, 
                    artist_lastName,
                    artist_born,
                    artist_died,
                    artist_origin,
                    artist_influence,
                    artist_desc
                )
                VALUES(
                    :artist_id,
                    :artist_fullName,
                    :artist_lastName,
                    :artist_born,
                    :artist_died,
                    :artist_origin,
                    :artist_influence,
                    :artist_desc
                )
            ');
            $res = $stmt->execute($this->getArrayOfAttributesForSTMT());
            if(!$res){
                $this->log("Record was not created. Type: ".self::$enittyName." ID: ". $this->getPdoDb()->lastInsertId() . PHP_EOL);
                return false;
            }
            $this->log("Record was created. Type: ".self::$enittyName." ID: ". $this->getPdoDb()->lastInsertId() . PHP_EOL);
            return $this->getPdoDb()->lastInsertId();
        }
        $this->log("Cannot Connet to DB. Record was not created. Type: ".self::$enittyName." ID: " . PHP_EOL);
        return false;
    }


    /**
     * Get record by id
     *
     * @param $id
     * @return mixed|void
     */
    public function retrieveOneById($id = 0)
    {
        $this->log("Start Retireiving ".self::$enittyName." by ID " . (int) $id);
        if($this->getPdoDb() !== null){
            $stmt = $this->getPdoDb()->prepare('SELECT *
                FROM  ' . self::$table    . '
                WHERE ' . self::$table_id . ' = ?')
            ;
            $stmt->execute([$id]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->log("Result Retireiving ".self::$enittyName." by ID: record retrieved " . PHP_EOL);
            return $record;
        }
        $this->log("Result Retireiving ".self::$enittyName." by ID: false " . PHP_EOL);
        $this->log("End Retireiving ".self::$enittyName." by ID" . PHP_EOL);
        return false;
    }


    /**
     * Update record
     *
     * @return false|mixed|void
     */
    public function update(){
        if($this->getId() !== null){

            $values = $this->getArrayOfAttributes();

            $attributes_changed_array = [];
            foreach ($this->getAttributesModified() as $changed_attribute){
                if(isset($values[$changed_attribute])){
                    $attributes_changed_array[$changed_attribute] = $values[$changed_attribute];
                }
            }

            if(isset($attributes_changed_array[self::$table_id])){
                unset($attributes_changed_array[self::$table_id]);
            }

            return $this->updateOneById($this->getId(), $attributes_changed_array);
        }
        return false;
    }


    /**
     * Update record by id
     *
     * @param $id
     * @param $values
     * @return mixed|void
     */
    public function updateOneById($id, $values = [])
    {
        $this->log("Start. Update ".self::$enittyName);
        if($this->getPdoDb() !== null && is_array($values) && count($values)){

            $keys = array_keys($values);
            $update_columns_params = [];
            foreach ($keys as $column){
                $update_columns_params[] = $column . " = :" . $column;
            }
            $update_columns = implode(", ", $update_columns_params);

            $update_values = [];
            foreach ($values as $k => $v){
                $update_values[":" . $k] = $v;
            }
            $update_values[":" . self::$table_id] = $id;

            $sql = 'UPDATE ' . self::$table    . ' SET
                    '.$update_columns .'
                WHERE '.self::$table_id.' = :'.self::$table_id.' 
            ';

            $stmt = $this->getPdoDb()->prepare($sql);
            $res = $stmt->execute($update_values);

            if(!$res){
                $this->log("Record was not update. Type: ".self::$enittyName." ID: ". $id . PHP_EOL);
                return false;
            }
            $this->log("Record was update. Type: ".self::$enittyName." ID: ". $id . PHP_EOL);
            return $this->getPdoDb()->lastInsertId();
        }
        $this->log("Cannot Connet to DB. Record was not update. Type: ".self::$enittyName." ID: " . (int) $id . PHP_EOL);
        return false;
    }


    /**
     * Delete record by id
     *
     * @param $id
     * @return mixed|void
     */
    public function deleteOneById($id)
    {
        $this->log("Start Deleting ".self::$enittyName." by ID " . (int) $id);
        if($this->getPdoDb() !== null){
            $stmt = $this->getPdoDb()->prepare('DELETE FROM  ' . self::$table    . '
                WHERE ' . self::$table_id . ' = ?')
            ;
            $res = $stmt->execute([(int) $id]);
            $this->log("Result Deleting ".self::$enittyName." by ID: record deleted " . PHP_EOL);
            return $res;
        }
        $this->log("Result Deleting ".self::$enittyName." by ID: false " . PHP_EOL);
        $this->log("End Deleting ".self::$enittyName." by ID" . PHP_EOL);
        return false;
    }


    /**
     * Get all of the attributes in array
     *
     * @return array
     */
    public function getArrayOfAttributes(){
        $array = [];
        $array["artist_id"]        = $this->getId();
        $array["artist_fullName"]  = $this->getFullName();
        $array["artist_lastName"]  = $this->getLastName();
        $array["artist_born"]      = $this->getBorn();
        $array["artist_died"]      = $this->getDied();
        $array["artist_origin"]    = $this->getOrigin();
        $array["artist_influence"] = $this->getInfluence();
        $array["artist_desc"]      = $this->getDescription();
        return $array;
    }

    /**
     * Get all of the attributes in array for PDO Stmp
     *
     * @return array
     */
    private function getArrayOfAttributesForSTMT(){
        $array = [];
        $array[":artist_id"]        = $this->getId();
        $array[":artist_fullName"]  = $this->getFullName();
        $array[":artist_lastName"]  = $this->getLastName();
        $array[":artist_born"]      = $this->getBorn();
        $array[":artist_died"]      = $this->getDied();
        $array[":artist_origin"]    = $this->getOrigin();
        $array[":artist_influence"] = $this->getInfluence();
        $array[":artist_desc"]      = $this->getDescription();
        return $array;
    }


    /**
     * Getters and Setters
     */


    /**
     * Get ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->artist_id;
    }

    /**
     * Set id of the record
     *
     * @param integer $id
     * @return boolean
     */
    public function setId($id)
    {
        if($this->artist_id != $id){
            $this->artist_id = $id;
            $this->register_a_change("artist_id");
            return true;
        }
        return false;
    }


    /**
     * Get First Name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->artist_fullName;
    }

    /**
     * Set Full Name
     *
     * @param string $artist_fullName
     * @return boolean
     */
    public function setFullName($artist_fullName = '')
    {
        if($this->artist_fullName != $artist_fullName){
            $this->artist_fullName = $artist_fullName;
            $this->register_a_change("artist_fullName");
            return true;
        }
        return false;
    }

    /**
     * Get First Name
     *
     * @return string
     */
    public function getFirstName()
    {
        return explode("_", $this->getFullName()[0]) ;
    }

    /**
     * Get Last Name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->artist_lastName;
    }

    /**
     * Set Last Name
     *
     * @param string $artist_lastName
     * @return boolean
     */
    public function setLastName($artist_lastName = '')
    {
        if($this->artist_lastName != $artist_lastName){
            $this->artist_lastName = $artist_lastName;
            $this->register_a_change("artist_lastName");
            return true;
        }
        return false;
    }

    /**
     * Get year of birth
     *
     * @return integer
     */
    public function getBorn()
    {
        return $this->artist_born;
    }

    /**
     * Set Year of birth
     *
     * @param integer $artist_born
     * @return boolean
     */
    public function setBorn($artist_born)
    {
        if($this->artist_born != $artist_born){
            $this->artist_born = $artist_born;
            $this->register_a_change("artist_born");
            return true;
        }
        return false;
    }

    /**
     * Get Year of death
     *
     * @return integer
     */
    public function getDied()
    {
        return $this->artist_died;
    }

    /**
     * Set year of death
     *
     * @param integer $artist_died
     * @return boolean
     */
    public function setDied($artist_died)
    {
        if($this->artist_died != $artist_died){
            $this->artist_died = $artist_died;
            $this->register_a_change("artist_died");
            return true;
        }
        return false;
    }

    /**
     * Get artist_influence of artist
     *
     * @return string
     */
    public function getOrigin()
    {
        return $this->artist_origin;
    }

    /**
     * Set artist_origin of artist
     *
     * @param string $artist_origin
     * @return boolean
     */
    public function setOrigin($artist_origin)
    {
        if($this->artist_origin != $artist_origin){
            $this->artist_origin = $artist_origin;
            $this->register_a_change("artist_origin");
            return true;
        }
        return false;
    }

    /**
     * Get artist_influence of artist
     *
     * @return string
     */
    public function getInfluence()
    {
        return $this->artist_influence;
    }

    /**
     * Set artist_influence of artist
     *
     * @param string $artist_influence
     * @return boolean
     */
    public function setInfluence($artist_influence)
    {
        if($this->artist_influence != $artist_influence){
            $this->artist_influence = $artist_influence;
            $this->register_a_change("artist_influence");
            return true;
        }
        return false;
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->artist_desc;
    }

    /**
     * Set Description
     *
     * @param string $artist_desc
     * @return boolean
     */
    public function setDescription($artist_desc = '')
    {
        if($this->artist_desc != $artist_desc){
            $this->artist_desc = $artist_desc;
            $this->register_a_change("artist_desc");
            return true;
        }
        return false;
    }


    /**
     * Helper function to return string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return $this->printArray($this->getArrayOfAttributes());
    }
}
