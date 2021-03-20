<?php
require_once 'Log.php';

/**
 * Class Model
 *
 * Base class to handle a record interactions with database
 */
abstract class Model
{
    private $pdo_db = null;

    /**
     * ID of the record
     *
     * @var integer
     */
    private $id = null;

    /**
     * Shows if model modified
     *
     * @var boolean
     */
    private $is_modified = false;

    /**
     * Array of attributes modified
     *
     * @var array
     */
    private $attributes_modifled = [];

    /**
     * Instance of Log Class
     * to log events
     *
     * @var Log
     */
    private $log;

    /**
     * Create a new record
     *
     * @return mixed
     */
    public abstract function create();

    /**
     * Get a record by id
     *
     * @param $values
     * @return mixed
     */
    public abstract function retrieveOneById($id);

    /**
     * Update record by id
     *
     * @param $id
     * @param $values
     * @return mixed
     */
    public abstract function updateOneById($id, $values);

    /**
     * Delete record by id
     *
     * @param $id
     * @return mixed
     */
    public abstract function deleteOneById($id);

    public function __construct($id = 0)
    {
        $this->log = new Log();
        $this->retrieveOneById($id);
    }

    public function log($message = ''){
        $this->log->write($message);
    }

    /**
     *  Save changes
     */
    public function save()
    {
        if ($this->getId() === null) {
            return $this->create();
        } else {
            if ($this->is_modified()) {
                return $this->update();
            }
        }
        return false;
    }

    /**
     * Return whether record was changed
     *
     * @return bool
     */
    public function is_modified()
    {
        return $this->is_modified;
    }

    /**
     * Sets whether record was changed
     *
     * @return bool
     */
    public function setIsModified($is_modified)
    {
        $this->is_modified = $is_modified;
    }

    /**
     * Get ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id of the record
     *
     * @param integer $id
     * @return boolean
     */
    public function setId($id)
    {
        if($this->id != $id){
            $this->id = $id;
            $this->register_a_change("id");
            return true;
        }
        return false;
    }


    /**
     * Get Modified Attributes
     *
     * @return array
     */
    public function getAttributesModified(){
        return $this->attributes_modifled;
    }


    /**
     * Add attribute to Modified Attributes
     *
     * @param string $attribute
     */
    public function addToAttributesModified($attribute = ''){
        if(!in_array($attribute, $this->attributes_modifled)){
            $this->attributes_modifled[] = $attribute;
        }
    }


    /**
     * Remove attribute from Modified Attributes
     *
     * @param string $attribute
     */
    public function removeFromAttributesModified($attribute = ''){
        if(in_array($attribute, $this->attributes_modifled)){
            foreach($this->attributes_modifled as $key => $val)
            {
                if($val == $attribute)
                {
                    unset($this->attributes_modifled[$key]);
                }
            }
        }
    }

    public function register_a_change($attribute = ""){
        $this->addToAttributesModified($attribute);
        $this->setIsModified(true);
    }

    /**
     * Helper function to print array key=>valur
     *
     * @param array $arr
     * @return string
     */
    public function printArray($arr = []){
        $output = '';
        if(is_array($arr) && count($arr)){
            foreach ($arr as $key => $value){
                $output .= $key . ' => ' . $value . ', ';
            }
        }
        return $output;
    }

    /**
     * @return null
     */
    public function getPdoDb()
    {
        return $this->pdo_db;
    }

    /**
     * @param null $pdo_db
     */
    public function setPdoDb($pdo_db): void
    {
        $this->pdo_db = $pdo_db;
    }
}
