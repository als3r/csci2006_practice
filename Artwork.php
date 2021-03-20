<?php
require_once 'Model.php';

/**
 * Class Artwork
 * Extends Model
 *
 * Handles interactions with a record of the artwork
 */
class Artwork extends Model
{

    static $enittyName = "Artwork";
    static $table      = "Artwork";
    static $table_id   = "artwork_id";

    /**
     * ID of the artwork
     * @var integer
     */
    public $artwork_id;

    /**
     * Artist
     * @var Artist
     */
    public $artwork_artist;

    /**
     * Artwork Title
     * @var string
     */
    public $artwork_name;

    /**
     * Id of the location
     * @var integer
     */
    public $artwork_loc;

    /**
     * Artwork Description
     * @var string
     */
    public $artwork_desc;

    /**
     * Price of the Artwork
     * @var float
     */
    public $artwork_reprintPrice;


    // Data Set
    public $data = [

    ];

    // Default Data for a record
    public const DEFAULT_DATA = [
        "id" => null,
        "artist_id" => 0,
        "artwork_name" => "",
        "artwork_loc" => 0,
        "artwork_reprintPrice" => 0,
        "artwork_desc" => "",
    ];


    /**
     * Artwork constructor.
     *
     *  Loads artwork record by id
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
            $arr["artwork_id"],
            $arr["artwork_artist"],
            $arr["artwork_name"],
            $arr["artwork_loc"],
            $arr["artwork_reprintPrice"],
            $arr["artwork_desc"]
        )) {
            $this->setArtworkId($arr["artwork_id"]);
            $this->setArtworkArtist($arr["artwork_artist"]);
            $this->setArtworkName($arr["artwork_name"]);
            $this->setArtworkLoc($arr["artwork_loc"]);
            $this->setArtworkReprintPrice($arr["artwork_reprintPrice"]);
            $this->setArtworkDescription($arr["artwork_desc"]);
        }
        $this->log("Retrieved Object: (type: Artist, id: ".(int) $id.")" . $this->toString());
        return true;
    }


    /**
     * Get a record (array) from Data array (data set) By ID
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

        $stmt = $pdo->prepare('SELECT artwork_id as id, artwork_name as name
                FROM  ' . self::$table)
        ;
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Create a record of artowrk
     *
     * @return mixed|void
     */
    public function create()
    {
        $this->log("Start. Create ".self::$enittyName);
        if($this->getPdoDb() !== null){
            $stmt = $this->getPdoDb()->prepare('INSERT INTO ' . self::$table    . '
                (
                    artwork_id,
                    artwork_artist,
                    artwork_name,
                    artwork_loc,
                    artwork_reprintPrice,
                    artwork_desc
                )
                VALUES(
                    :artwork_id,
                    :artwork_artist,
                    :artwork_name,
                    :artwork_loc,
                    :artwork_reprintPrice,
                    :artwork_desc
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
    public function retrieveOneById($id)
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
        if($this->getArtworkId() !== null){

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

            return $this->updateOneById($this->getArtworkId(), $attributes_changed_array);
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
    private function getArrayOfAttributes(){
        $array = [];
        $array["artwork_id"]           = $this->getArtworkId();
        $array["artwork_artist"]       = $this->getArtworkArtist();
        $array["artwork_name"]         = $this->getArtworkName();
        $array["artwork_loc"]          = $this->getArtworkLoc();
        $array["artwork_reprintPrice"] = $this->getArtworkReprintPrice();
        $array["artwork_desc"]         = $this->getArtworkDescription();
        return $array;
    }

    /**
     * Get all of the attributes in array for PDO Stmp
     *
     * @return array
     */
    private function getArrayOfAttributesForSTMT(){
        $array = [];
        $array[":artwork_id"]           = $this->getArtworkId();
        $array[":artwork_artist"]       = $this->getArtworkArtist();
        $array[":artwork_name"]         = $this->getArtworkName();
        $array[":artwork_loc"]          = $this->getArtworkLoc();
        $array[":artwork_reprintPrice"] = $this->getArtworkReprintPrice();
        $array[":artwork_desc"]         = $this->getArtworkDescription();
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
        return $this->getArtworkId();
    }

    /**
     * Set id of the record
     *
     * @param integer artwork_id
     * @return boolean
     */
    public function setId($artwork_id)
    {
        return $this->setArtworkId($artwork_id);
    }

    /**
     * Get ID
     *
     * @return integer
     */
    public function getArtworkId()
    {
        return $this->artwork_id;
    }

    /**
     * Set id of the record
     *
     * @param integer artwork_id
     * @return boolean
     */
    public function setArtworkId($artwork_id)
    {
        if($this->artwork_id != $artwork_id){
            $this->artwork_id = $artwork_id;
            $this->register_a_change("id");
            return true;
        }
        return false;
    }

    /**
     * Get artwork artist for artwork
     *
     * @return integer
     */
    public function getArtworkArtist()
    {
        return $this->artwork_artist;
    }

    /**
     * Set artwork artist
     *
     * @param integer $artwork_artist
     * @return boolean
     */
    public function setArtworkArtist($artwork_artist)
    {
        if($this->artwork_artist != $artwork_artist){
            $this->artwork_artist = $artwork_artist;
            $this->register_a_change("artwork_artist");
            return true;
        }
        return false;
    }

    /**
     * Get artwork name
     *
     * @return mixed
     */
    public function getArtworkName()
    {
        return $this->artwork_name;
    }

    /**
     * Set artwork name
     *
     * @param string $artwork_name
     * @return boolean
     */
    public function setArtworkName($artwork_name)
    {
        if($this->artwork_name != $artwork_name){
            $this->artwork_name = $artwork_name;
            $this->register_a_change("artwork_name");
            return true;
        }
        return false;
    }

    /**
     * Get artwork artwork_loc
     *
     * @return string
     */
    public function getArtworkLoc()
    {
        return $this->artwork_loc;
    }

    /**
     * Set artwork artwork_loc
     *
     * @param string $artwork_loc
     * @return boolean
     */
    public function setArtworkLoc($artwork_loc)
    {
        if($this->artwork_loc != $artwork_loc){
            $this->artwork_loc = $artwork_loc;
            $this->register_a_change("artwork_loc");
            return true;
        }
        return false;
    }


    /**
     * Get artwork artwork_desc
     *
     * @return string
     */
    public function getArtworkDescription()
    {
        return $this->artwork_desc;
    }

    /**
     * Set artwork artwork_desc
     *
     * @param string $artwork_desc
     * @return boolean
     */
    public function setArtworkDescription($artwork_desc)
    {
        if($this->artwork_desc != $artwork_desc){
            $this->artwork_desc = $artwork_desc;
            $this->register_a_change("artwork_desc");
            return true;
        }
        return false;
    }

    /**
     * Get price for artwork
     *
     * @return float
     */
    public function getArtworkReprintPrice()
    {
        return $this->artwork_reprintPrice;
    }

    /**
     * Set Price for artwork
     *
     * @param float $artwork_reprintPrice
     */
    public function setArtworkReprintPrice($artwork_reprintPrice)
    {
        if($this->artwork_reprintPrice != $artwork_reprintPrice){
            $this->artwork_reprintPrice = $artwork_reprintPrice;
            $this->register_a_change("artwork_reprintPrice");
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
