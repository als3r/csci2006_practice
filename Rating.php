<?php
require_once 'Model.php';

/**
 * Class Rating
 * Extends Model
 *
 * Handles interactions with a rating for artist or artwork
 */
class Rating extends Model
{

    const MIN_RATING = 1;
    const MAX_RATING = 10;

    const TYPE_ARTIST  = 'Artist';
    const TYPE_ARTWORK = 'Artwork';

    const TYPES = [
        self::TYPE_ARTIST,
        self::TYPE_ARTWORK,
    ];

    /**
     * ID of the rating
     * @var integer
     */
    private $id;

    /**
     * Rating Type (Artist|Artwork)
     * @var string
     */
    private $rating_type;

    /**
     * Id of the entity, which will use rating
     * @var int
     */
    private $entity_id;

    /*
     * User ID
     * @var int
     */
    private $user_id;

    /*
     * Rating value (between MIN_RATING and MAX_RATING)
     * @var float
     */
    private $rating_value;

    // Data Set
    private $data = [
        1 => [
            "id"           => 1,
            "rating_type"  => "Artist",
            "entity_id"    => 1,
            "user_id"      => 1,
            "rating_value" => 9,
        ],
        2 => [
            "id"           => 2,
            "rating_type"  => "Artist",
            "entity_id"    => 1,
            "user_id"      => 2,
            "rating_value" => 8,
        ],
        3 => [
            "id"           => 3,
            "rating_type"  => "Artist",
            "entity_id"    => 1,
            "user_id"      => 3,
            "rating_value" => 6,
        ],
        4 => [
            "id"           => 4,
            "rating_type"  => "Artist",
            "entity_id"    => 1,
            "user_id"      => 4,
            "rating_value" => 10,
        ],
        5 => [
            "id"           => 5,
            "rating_type"  => "Artist",
            "entity_id"    => 1,
            "user_id"      => 5,
            "rating_value" => 7,
        ],
        6 => [
            "id"           => 6,
            "rating_type"  => "Artist",
            "entity_id"    => 2,
            "user_id"      => 1,
            "rating_value" => 9,
        ],
        7 => [
            "id"           => 7,
            "rating_type"  => "Artist",
            "entity_id"    => 2,
            "user_id"      => 2,
            "rating_value" => 10,
        ],
        8 => [
            "id"           => 8,
            "rating_type"  => "Artist",
            "entity_id"    => 2,
            "user_id"      => 3,
            "rating_value" => 5,
        ],
        9 => [
            "id"           => 9,
            "rating_type"  => "Artist",
            "entity_id"    => 2,
            "user_id"      => 4,
            "rating_value" => 3,
        ],
        10 => [
            "id"           => 10,
            "rating_type"  => "Artist",
            "entity_id"    => 2,
            "user_id"      => 5,
            "rating_value" => 9,
        ],
        11 => [
            "id"           => 11,
            "rating_type"  => "Artwork",
            "entity_id"    => 1,
            "user_id"      => 1,
            "rating_value" => 9,
        ],
        12 => [
            "id"           => 12,
            "rating_type"  => "Artwork",
            "entity_id"    => 1,
            "user_id"      => 2,
            "rating_value" => 8,
        ],
        13 => [
            "id"           => 13,
            "rating_type"  => "Artwork",
            "entity_id"    => 1,
            "user_id"      => 3,
            "rating_value" => 10,
        ],
        14 => [
            "id"           => 14,
            "rating_type"  => "Artwork",
            "entity_id"    => 1,
            "user_id"      => 4,
            "rating_value" => 10,
        ],
        15 => [
            "id"           => 15,
            "rating_type"  => "Artwork",
            "entity_id"    => 1,
            "user_id"      => 5,
            "rating_value" => 4,
        ],
        16 => [
            "id"           => 16,
            "rating_type"  => "Artwork",
            "entity_id"    => 2,
            "user_id"      => 1,
            "rating_value" => 9,
        ],
        17 => [
            "id"           => 17,
            "rating_type"  => "Artwork",
            "entity_id"    => 2,
            "user_id"      => 2,
            "rating_value" => 10,
        ],
        18 => [
            "id"           => 18,
            "rating_type"  => "Artwork",
            "entity_id"    => 2,
            "user_id"      => 3,
            "rating_value" => 10,
        ],
        19 => [
            "id"           => 19,
            "rating_type"  => "Artwork",
            "entity_id"    => 2,
            "user_id"      => 4,
            "rating_value" => 6,
        ],
        20 => [
            "id"           => 20,
            "rating_type"  => "Artwork",
            "entity_id"    => 2,
            "user_id"      => 5,
            "rating_value" => 3,
        ]
    ];

    // Default Data for a record
    private const DEFAULT_DATA = [
      "id"           => null,
      "rating_type"  => "Artist",
      "entity_id"    => null,
      "user_id"      => null,
      "rating_value" => 1,
    ];


    /**
     * Artist constructor.
     *
     * Loads artist record by id
     *
     * @param $id
     */
    public function __construct($id = 0)
    {
        parent::__construct($id);
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

        $this->id           = isset($arr["id"])           ? $arr["id"]           : null;
        $this->rating_type  = isset($arr["rating_type"])  ? $arr["rating_type"]  : '';
        $this->entity_id    = isset($arr["entity_id"])    ? $arr["entity_id"]    : '';
        $this->user_id      = isset($arr["user_id"])      ? $arr["user_id"]      : '';
        $this->rating_value = isset($arr["rating_value"]) ? $arr["rating_value"] : '';
        $this->log("Retrieved Object: (type: Rating, id: ".(int) $id.")" . $this->toString());
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
        if (isset($this->data[(int)$id])) {
            return $this->data[(int)$id];
        } else {
            return self::DEFAULT_DATA;
        }
    }


    /**
     * Create a record of rating
     *
     * @return mixed|void
     */
    public function create()
    {
        $values = $this->getArrayOfAttributes();
        // mocking creating a record in db, $created_id - "returned" id from db
        $created_id = rand(100,200);
        $values['id'] = $created_id;
        $this->log("Object Create(type: Rating, id: " . (int) $values['id'] . "): " . $this->printArray($values) . PHP_EOL);

        return $created_id;
    }


    /**
     * Get record by id
     *
     * @param $id
     * @return mixed|void
     */
    public function retrieveOneById($id)
    {
        $this->log("Start Retireiving Rating by ID " . (int) $id);
        $this->loadData($id);
        $this->log("End Retireiving Rating by ID" . PHP_EOL);
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
        if(empty($values)){
            $values = $this->getArrayOfAttributes();
        }

        $attributes_changed_array = [];
        foreach ($this->getAttributesModified() as $changed_attribute){
            if(isset($values[$changed_attribute]))
                $attributes_changed_array[$changed_attribute] = $values[$changed_attribute];
        }

        $this->log("Object Edits Saved (type: Rating, id: " . (int) $id . "): Changed attributes: " . $this->printArray($attributes_changed_array));
        $this->log("Object Edits Saved (type: Rating, id: " . (int) $id . "): New Object: " . $this->printArray($values) . PHP_EOL);
    }


    /**
     * Delete record by id
     *
     * @param $id
     * @return mixed|void
     */
    public function deleteOneById($id)
    {
        $this->log("Object Deleted (type: Rating, id: " . (int) $id . ")" . PHP_EOL);
    }


    /**
     * Get all of the attributes in array
     *
     * @return array
     */
    private function getArrayOfAttributes(){
        $array = [];
        $array["id"]           = $this->id;
        $array["rating_type"]  = $this->first_name;
        $array["entity_id"]    = $this->middle_name;
        $array["user_id"]      = $this->last_name;
        $array["rating_value"] = $this->description;
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
     * Get Rating Type
     *
     * @return string
     */
    public function getRatingType()
    {
        return $this->rating_type;
    }

    /**
     * Set Rating Type
     *
     * @param string $rating_type
     * @return boolean
     */
    public function setRatingType($rating_type = '')
    {
        if($this->rating_type != $rating_type){
            $this->rating_type = $rating_type;
            $this->register_a_change("rating_type");
            return true;
        }
        return false;
    }

    /**
     * Get Entity Id
     *
     * @return string
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }

    /**
     * Set Entity Id
     *
     * @param int $entity_id
     * @return boolean
     */
    public function setEntityId($entity_id = '')
    {
        if($this->entity_id != $entity_id){
            $this->entity_id = $entity_id;
            $this->register_a_change("entity_id");
            return true;
        }
        return false;
    }

    /**
     * Get User ID
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set User ID
     *
     * @param string $user_id
     * @return boolean
     */
    public function setUserId($user_id = '')
    {
        if($this->user_id != $user_id){
            $this->user_id = $user_id;
            $this->register_a_change("user_id");
            return true;
        }
        return false;
    }

    /**
     * Get Rating Value
     *
     * @return string
     */
    public function getRatingValue()
    {
        return $this->rating_value;
    }

    /**
     * Set Rating Value
     *
     * @param float $rating_value
     * @return boolean
     */
    public function setRatingValue($rating_value = '')
    {
        if($this->rating_value != $rating_value){
            $this->rating_value = $rating_value;
            $this->register_a_change("rating_value");
            return true;
        }
        return false;
    }



    /**
    * Get Average Rating For Entity
    *
    * @param int $entity_id
    * @param string $rating_type
    * @return float
    */
    public function getAverageRating($entity_id = 0, $rating_type = '')
    {
        $number_ratings = 0;
        $total_rating   = 0;

        if(is_array($this->data) && count($this->data)){

        }
        foreach ($this->data as $key => $rating_row) {
          if(
            isset($rating_row['entity_id'], $rating_row['rating_type'],
                  $rating_row['user_id'],   $rating_row['rating_value']
            )
            && $rating_row['entity_id']   == $entity_id
            && $rating_row['rating_type'] == $rating_type
          ) {
            $number_ratings++;
            $total_rating += $rating_row['rating_value'];
          }
        }

        return $number_ratings == 0 ? 0 : $total_rating/$number_ratings;
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
