<?php
require_once 'Model.php';

/**
 * Class Facet
 * Extends Model
 *
 * Handles interactions with a record of the artist
 */
class Facet extends Model
{
    static $enittyName = "Facet";
    static $table      = "Facet";
    static $table_id   = "facet_artwork";

    /**
     * Artist ID of the artwork
     * @var integer
     */
    private $facet_artwork;

    /**
     * Artist Facet Key
     * @var string
     */
    private $facet_key;

    /*
     * Facet Value
     * @var string
     */
    private $facet_value;


    // Default Data for a record
    private const DEFAULT_DATA = [
        "facet_artwork"  => null,
        "facet_key"   => "",
        "facet_value" => "",
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
                $arr["facet_artwork"],
                $arr["facet_key"],
                $arr["facet_value"]
        )) {
            $this->setFacetArtwork( $arr["facet_artwork"] );
            $this->setFacetKey(     $arr["facet_key"]     );
            $this->setFacetValue(   $arr["facet_value"]   );
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
     * Get key => value pairs for all Facets
     *
     * @param $pdo
     * @return mixed
     */
    public static function getAll($pdo, $facetArtwork = null){

        $stmt = $pdo->prepare("SELECT facet_key as 'key', facet_value as 'value'
                FROM  " . self::$table . " WHERE facet_artwork = " . (int) $facetArtwork
        );
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
                    facet_artwork,
                    facet_key, 
                    facet_value,
                )
                VALUES(
                    :facet_artwork,
                    :facet_key,
                    :facet_value,
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
        $array["facet_artwork"] = $this->facet_artwork;
        $array["facet_key"]     = $this->facet_key;
        $array["facet_value"]   = $this->facet_value;
        return $array;
    }

    /**
     * Get all of the attributes in array for PDO Stmp
     *
     * @return array
     */
    private function getArrayOfAttributesForSTMT(){
        $array = [];
        $array[":facet_artwork"] = $this->getId();
        $array[":facet_key"]     = $this->getFacetKey();
        $array[":facet_value"]   = $this->getFavetValue();
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
    public function getFacetArtwork()
    {
        return $this->facet_artwork;
    }

    /**
     * Set id of the record
     *
     * @param integer $id
     * @return boolean
     */
    public function setFacetArtwork($id)
    {
        if($this->facet_artwork != $id){
            $this->facet_artwork = $id;
            $this->register_a_change("facet_artwork");
            return true;
        }
        return false;
    }


    /**
     * Get Facet Key
     *
     * @return string
     */
    public function getFacetKey()
    {
        return $this->facet_key;
    }

    /**
     * Set Facet Key
     *
     * @param string $facet_key
     * @return boolean
     */
    public function setFacetKey($facet_key = '')
    {
        if($this->facet_key != $facet_key){
            $this->facet_key = $facet_key;
            $this->register_a_change("facet_key");
            return true;
        }
        return false;
    }


    /**
     * Get Facet Value
     *
     * @return string
     */
    public function getFacetValue()
    {
        return $this->facet_value;
    }

    /**
     * Set Facet Value
     *
     * @param string $facet_value
     * @return boolean
     */
    public function setFacetValue($facet_value = '')
    {
        if($this->facet_value != $facet_value){
            $this->facet_value = $facet_value;
            $this->register_a_change("facet_value");
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
