<?php
require_once 'Model.php';

/**
 * Class Genre
 * Extends Model
 *
 * Handles interactions with a record of the artist
 */
class Genre extends Model
{
    static $enittyName = "Genre";
    static $table      = "Genre";
    static $table_id   = "genre_id";

    /**
     * Genre ID
     * @var integer
     */
    private $genre_id;

    /**
     * Artist Genre Name
     * @var string
     */
    private $genre_name;

    /**
     * Artist Genre Description
     * @var string
     */
    private $genre_desc;


    // Default Data for a record
    private const DEFAULT_DATA = [
        "genre_id"  => null,
        "genre_name"   => "",
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
                $arr["genre_id"],
                $arr["genre_name"],
                $arr["genre_desc"]
        )) {
            $this->setGenreId(          $arr["genre_id"]   );
            $this->setGenreName(        $arr["genre_name"] );
            $this->setGenreDescription( $arr["genre_desc"] );
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
     * Get Subjects key => value pairs for artwork
     *
     * @param $pdo
     * @return mixed
     */
    public static function getAll($pdo, $artWork_id = null){

        $stmt = $pdo->prepare("
            SELECT genre_id as 'genre_id', genre_name as 'key', genre_desc as 'genre_desc'
            FROM  " . self::$table . "
            INNER JOIN artGenre ON genre_id = ag_genre
            WHERE ag_artwork = " . (int) $artWork_id . "
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
                    genre_id,
                    genre_name, 
                    facet_value,
                )
                VALUES(
                    :genre_id,
                    :genre_name,
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
        $array["genre_id"]   = $this->genre_id;
        $array["genre_name"] = $this->genre_name;
        $array["genre_desc"] = $this->genre_desc;
        return $array;
    }

    /**
     * Get all of the attributes in array for PDO Stmp
     *
     * @return array
     */
    private function getArrayOfAttributesForSTMT(){
        $array = [];
        $array[":genre_id"]   = $this->getId();
        $array[":genre_name"] = $this->getGenreName();
        $array[":genre_desc"] = $this->getGenreDescription();
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
        return $this->getGenreId();
    }

    /**
     * Get ID
     *
     * @return integer
     */
    public function getGenreId()
    {
        return $this->genre_id;
    }

    /**
     * Set id of the record
     *
     * @param integer $id
     * @return boolean
     */
    public function setGenreId($id)
    {
        if($this->genre_id != $id){
            $this->genre_id = $id;
            $this->register_a_change("genre_id");
            return true;
        }
        return false;
    }


    /**
     * Get Genre Name
     *
     * @return string
     */
    public function getGenreName()
    {
        return $this->genre_name;
    }

    /**
     * Set Genre Name
     *
     * @param string $genre_name
     * @return boolean
     */
    public function setGenreName($genre_name = '')
    {
        if($this->genre_name != $genre_name){
            $this->genre_name = $genre_name;
            $this->register_a_change("genre_name");
            return true;
        }
        return false;
    }


    /**
     * Get Genre Description
     *
     * @return string
     */
    public function getGenreDescription()
    {
        return $this->genre_desc;
    }

    /**
     * Set Genre Description
     *
     * @param string $genre_desc
     * @return boolean
     */
    public function setGenreDescription($genre_desc = '')
    {
        if($this->genre_desc != $genre_desc){
            $this->genre_desc = $genre_desc;
            $this->register_a_change("genre_desc");
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
