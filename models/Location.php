<?php
require_once 'Model.php';

/**
 * Class Location  * Extends Model
 *
 * Handles interactions with a record of the artist
 */
class Location extends Model
{
    static $enittyName = "Location";
    static $table      = "Location";
    static $table_id   = "loc_id";

    /**
     * Location ID
     * @var integer
     */
    private $loc_id;

    /**
     * Artist Location Name
     * @var string
     */
    private $loc_name;


    // Default Data for a record
    private const DEFAULT_DATA = [
        "loc_id"   => null,
        "loc_name" => "",
    ];


    /**
     * Location constructor.
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
                $arr["loc_id"],
                $arr["loc_name"]
        )) {
            $this->setLocId( $arr["loc_id"] );
            $this->setLocName(     $arr["loc_name"]     );
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
     * Get LOcations key => value pairs for artwork
     *
     * @param $pdo
     * @return mixed
     */
    public static function getAll($pdo, $artWork_id = null){

        $stmt = $pdo->prepare("
            SELECT loc_name as 'key', loc_id as 'id'
            FROM  " . self::$table . "
        ");
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
                    loc_id,
                    loc_name, 
                    loc_desc,
                )
                VALUES(
                    :loc_id,
                    :loc_name,
                    :loc_desc,
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
    private function getArrayOfAttributes(){
        $array = [];
        $array["loc_id"]   = $this->loc_id;
        $array["loc_name"] = $this->loc_name;
        $array["loc_desc"] = $this->loc_desc;
        return $array;
    }

    /**
     * Get all of the attributes in array for PDO Stmp
     *
     * @return array
     */
    private function getArrayOfAttributesForSTMT(){
        $array = [];
        $array[":loc_id"]   = $this->getId();
        $array[":loc_name"] = $this->getLocName();
        $array[":loc_desc"] = $this->getLocDescription();
        return $array;
    }


    /**
     * Getters and Setters
     */


    /**
     * Get ID
     *
     * @return int
     */
    public function getId(){
        return $this->getLocId();
    }

    /**
     * Get ID
     *
     * @return integer
     */
    public function getLocId()
    {
        return $this->loc_id;
    }

    /**
     * Set id of the record
     *
     * @param integer $id
     * @return boolean
     */
    public function setLocId($id)
    {
        if($this->loc_id != $id){
            $this->loc_id = $id;
            $this->register_a_change("loc_id");
            return true;
        }
        return false;
    }


    /**
     * Get Location Name
     *
     * @return string
     */
    public function getLocName()
    {
        return $this->loc_name;
    }

    /**
     * Set Location Name
     *
     * @param string $loc_name
     * @return boolean
     */
    public function setLocName($loc_name = '')
    {
        if($this->loc_name != $loc_name){
            $this->loc_name = $loc_name;
            $this->register_a_change("loc_name");
            return true;
        }
        return false;
    }

    /**
     * Get Location Description
     *
     * @return string
     */
    public function getLocDescription()
    {
        return $this->loc_desc;
    }

    /**
     * Set Location Description
     *
     * @param string $loc_desc
     * @return boolean
     */
    public function setLocDescription($loc_desc = '')
    {
        if($this->loc_desc != $loc_desc){
            $this->loc_desc = $loc_desc;
            $this->register_a_change("loc_desc");
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
