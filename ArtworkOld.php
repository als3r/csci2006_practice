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
    /**
     * ID of the artwork
     * @var integer
     */
    public $id;

    /**
     * Id of the artist
     * @var integer
     */
    public $artist_id;

    /**
     * Artist full name
     * @var string
     */
    public $artist_name;

    /**
     * Artwork Title
     * @var string
     */
    public $title;

    /**
     * Artwork Description
     * @var string
     */
    public $description;

    /**
     * Price of the Artwork
     * @var float
     */
    public $price;

    /**
     * Date of the artwork
     * @var string
     */
    public $date;

    /**
     * Medium of the Artwork
     * @var string
     */
    public $medium;

    /**
     * Width of the Artwork in cm
     *
     * @var integer
     */
    public $width;

    /**
     * Height of the Artwork in cm
     *
     * @var integer
     */
    public $height;

    /**
     * Home of the artwork
     *
     * @var string
     */
    public $home;

    /**
     * Genres of the artwork
     *
     * @var
     */
    public $genres;

    /**
     * Subjects of the artwork
     *
     * @var
     */
    public $subjects;

    /**
     * Similar artwork (not used yet)
     *
     * @var string
     */
    public $similar_artwork;

    /**
     * Path to the image of the artwork
     * @var string
     */
    public $image;


    // Data Set
    public $data = [
        1 => [
            "id" => 1,
            "artist_id" => 1,
            "artist_name" => "Elisabeth Louise Le Brun",
            "title" => "Self-portrait in a Straw Hat",
            "description" => "The painting appears, after cleaning, to be an autograph replica of a picture, the original of which was painted in Brussels in 1782 in free imitation of Rubens’s ’Chapeau de Paille’, which LeBrun had seen in Antwerp. It was exhibited in Paris in 1782 at the Salon de la Correspondance. LeBrun’s original is recorded in a private collection in France.",
            "price" => 700,
            "date" => 1782,
            "medium" => "Oil on canvas",
            "width" => 98,
            "height" => 71,
            "home" => "National Gallery, London",
            "genres" => "Realism, Rococo",
            "subjects" => "People, Arts",
            "similar_artwork" => "",
            "image" => "13.jpg",
        ],
        2 => [
            "id" => 2,
            "artist_id" => 2,
            "artist_name" => "Anthony van Dyck",
            "title" => "William II, Prince of Orange, and his Bride, Mary Stuart",
            "description" => "The boy is fourteen and the girl only nine. William’s father, Frederick Henry, commissioned the celebrated Flemish painter Van Dyck to portray the young Dutch prince and English princess on the occasion of their marriage in London.
<br />The union with the daughter of the English king enhanced the status of the House of Orange.
<br />On her gown, Mary wears a gift from William, a large diamond brooch.",
            "price" => 800,
            "date" => 1641,
            "medium" => "Oil on canvas",
            "width" => 180,
            "height" => 132.2,
            "home" => "National Gallery, London",
            "genres" => "Realism",
            "subjects" => "People, Arts",
            "similar_artwork" => "",
            "image" => "374.jpg",
        ],
        3 => [
            "id" => 3,
            "artist_id" => 3,
            "artist_name" => "Nicolaes van Verendael",
            "title" => "Still Life with Flowers in a Glass Vase",
            "description" => "This painting dates to the period in Antwerp when hothouses became popular among the nobility and patrons ordered paintings to record their personal hothouse triumphs. Not all of the blooms would have bloomed at the same time, and the painting was meant more for decoration than for botanical accuracy. The work shows the following flower species: Rosa alba, Tropaeolum majus, Hepatica nobilis, rosemary, Tulipa, Delphinium, Aquilegia, Punica granatum, Rosa × centifolia.",
            "price" => 500,
            "date" => 1660,
            "medium" => "Oil on copper",
            "width" => 49.5,
            "height" => 39.5,
            "home" => "National Gallery, London",
            "genres" => "Realism, Rococo",
            "subjects" => "People, Arts",
            "similar_artwork" => "",
            "image" => "183.jpg",
        ],
    ];

    // Default Data for a record
    public const DEFAULT_DATA = [
        "id" => null,
        "artist_id" => 0,
        "artist_name" => "Default Artist",
        "title" => "Default Title",
        "description" => "Default Description",
        "price" => 0,
        "date" => 0,
        "medium" => "Default Medium",
        "width" => 0,
        "height" => 0,
        "home" => "Default Home",
        "genres" => "Default Genres",
        "subjects" => "Default Subjects",
        "similar_artwork" => "",
        "image" => "default.jpg",
    ];


    /**
     * Artwork constructor.
     *
     *  Loads artwork record by id
     *
     * @param $id
     */
    public function __construct($id = 0)
    {
        parent::__construct($id);
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

        $this->id              = isset($arr["id"])              ? $arr["id"] : null;
        $this->artist_id       = isset($arr["artist_id"])       ? $arr["artist_id"] : '';
        $this->artist_name     = isset($arr["artist_name"])     ? $arr["artist_name"] : '';
        $this->title           = isset($arr["title"])           ? $arr["title"] : '';
        $this->description     = isset($arr["description"])     ? $arr["description"] : '';
        $this->price           = isset($arr["price"])           ? $arr["price"] : '';
        $this->date            = isset($arr["date"])            ? $arr["date"] : '';
        $this->medium          = isset($arr["medium"])          ? $arr["medium"] : '';
        $this->width           = isset($arr["width"])           ? $arr["width"] : '';
        $this->height          = isset($arr["height"])          ? $arr["height"] : '';
        $this->home            = isset($arr["home"])            ? $arr["home"] : '';
        $this->genres          = isset($arr["genres"])          ? $arr["genres"] : '';
        $this->subjects        = isset($arr["subjects"])        ? $arr["subjects"] : '';
        $this->similar_artwork = isset($arr["similar_artwork"]) ? $arr["similar_artwork"] : '';
        $this->image           = isset($arr["image"])           ? $arr["image"] : '';
        $this->log("Retrieved Object: (type: Artwork, id: ".(int) $id.")" . $this->toString());
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
        if (isset($this->data[(int)$id])) {
            return $this->data[(int)$id];
        } else {
            return self::DEFAULT_DATA;
        }
    }


    /**
     * Create a record of artwork
     *
     * @return mixed|void
     */
    public function create()
    {
        $values = $this->getArrayOfAttributes();
        // mocking creating a record in db, $created_id - "returned" id from db
        $created_id = rand(100,200);
        $values['id'] = $created_id;
        $this->log("Object Create(type: Artwork, id: " . (int) $values['id'] . "): " . $this->printArray($values) . PHP_EOL);
    }


    /**
     * Get record by id
     *
     * @param $id
     * @return mixed|void
     */
    public function retrieveOneById($id)
    {
        $this->log("Start Retireiving Artwork by ID " . (int) $id);
        $this->loadData($id);
        $this->log("End Retireiving Artwork by ID" . PHP_EOL);
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

        $this->log("Object Edits Saved (type: Artwork, id: " . (int) $id . "): Changed attributes: " . $this->printArray($attributes_changed_array));
        $this->log("Object Edits Saved (type: Artwork, id: " . (int) $id . "): New Object: " . $this->printArray($this->getArrayOfAttributes()) . PHP_EOL);
    }


    /**
     * Delete record by id
     *
     * @param $id
     * @return mixed|void
     */
    public function deleteOneById($id)
    {
        $this->log("Object Deleted (type: Artwork, id: " . (int) $id . ")". PHP_EOL);
    }

    /**
     * Get all of the attributes in array
     *
     * @return array
     */
    private function getArrayOfAttributes(){
        $array = [];
        $array["id"]              = $this->id;
        $array["artist_id"]       = $this->artist_id;
        $array["artist_name"]     = $this->artist_name;
        $array["title"]           = $this->title;
        $array["description"]     = $this->description;
        $array["price"]           = $this->price;
        $array["date"]            = $this->date;
        $array["medium"]          = $this->medium;
        $array["width"]           = $this->width;
        $array["height"]          = $this->height;
        $array["home"]            = $this->home;
        $array["genres"]          = $this->genres;
        $array["subjects"]        = $this->subjects;
        $array["similar_artwork"] = $this->similar_artwork;
        $array["image"]           = $this->image;
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
     * Get artist id for artwork
     *
     * @return integer
     */
    public function getArtistId()
    {
        return $this->artist_id;
    }

    /**
     * Set artist id for artwork
     *
     * @param integer $artist_id
     * @return boolean
     */
    public function setArtistId($artist_id)
    {
        if($this->artist_id != $artist_id){
            $this->artist_id = $artist_id;
            $this->register_a_change("artist_id");
            return true;
        }
        return false;
    }

    /**
     * Get artist name for artwork
     *
     * @return string
     */
    public function getArtistName()
    {
        return $this->artist_name;
    }

    /**
     * Set artist name for artwork
     *
     * @param string $artist_name
     * @return boolean
     */
    public function setArtistName($artist_name)
    {
        if($this->artist_name != $artist_name){
            $this->artist_name = $artist_name;
            $this->register_a_change("artist_name");
            return true;
        }
        return false;
    }

    /**
     * Get artwork title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set artwork title
     *
     * @param string $title
     * @return boolean
     */
    public function setTitle($title)
    {
        if($this->title != $title){
            $this->title = $title;
            $this->register_a_change("title");
            return true;
        }
        return false;
    }

    /**
     * Get artwork description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set artwork description
     *
     * @param string $description
     * @return boolean
     */
    public function setDescription($description)
    {
        if($this->description != $description){
            $this->description = $description;
            $this->register_a_change("description");
            return true;
        }
        return false;
    }

    /**
     * Get price for artwork
     *
     * @return string
     */
    public function getPriceFormatted()
    {
        return '$' . number_format($this->getPrice(), 2);
    }

    /**
     * Get price for artwork
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set Price for artwork
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        if($this->price != $price){
            $this->price = $price;
            $this->register_a_change("price");
            return true;
        }
        return false;
    }

    /**
     * Get date for the artwork
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date for the artwork
     *
     * @param string $date
     * @return boolean
     */
    public function setDate($date)
    {
        if($this->date != $date){
            $this->date = $date;
            $this->register_a_change("date");
            return true;
        }
        return false;
    }

    /**
     * Get medium
     *
     * @return string
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * Set medium for artwork
     *
     * @param string $medium
     * @return boolean
     */
    public function setMedium($medium)
    {
        if($this->medium != $medium){
            $this->medium = $medium;
            $this->register_a_change("medium");
            return true;
        }
        return false;
    }

    /**
     * Get width of the artwork in cm
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param integer $width
     * @return boolean
     */
    public function setWidth($width)
    {
        if($this->width != $width){
            $this->width = $width;
            $this->register_a_change("width");
            return true;
        }
        return false;
    }

    /**
     * Get height of the artwork in cm
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param integer $height
     * @return boolean
     */
    public function setHeight($height)
    {
        if($this->height != $height){
            $this->height = $height;
            $this->register_a_change("height");
            return true;
        }
        return false;
    }

    /**
     * Get home
     *
     * @return string
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * Set home of the artwork
     *
     * @param string $home
     * @return boolean
     */
    public function setHome($home)
    {
        if($this->home != $home){
            $this->home = $home;
            $this->register_a_change("home");
            return true;
        }
        return false;
    }

    /**
     * Get genres
     *
     * @return string
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Set genres
     *
     * @param string $genres
     * @return boolean
     */
    public function setGenres($genres)
    {
        if($this->genres != $genres){
            $this->genres = $genres;
            $this->register_a_change("genres");
            return true;
        }
        return false;
    }

    /**
     * Get subjects
     *
     * @return string
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * Set subjects
     *
     * @param string $subjects
     * @return boolean
     */
    public function setSubjects($subjects)
    {
        if($this->subjects != $subjects){
            $this->subjects = $subjects;
            $this->register_a_change("subjects");
            return true;
        }
        return false;
    }

    /**
     * Get similar artwork
     *
     * @return string
     */
    public function getSimilarArtwork()
    {
        return $this->similar_artwork;
    }

    /**
     * Set Similar artwork
     *
     * @param string $similar_artwork
     * @return boolean
     */
    public function setSimilarArtwork($similar_artwork)
    {
        if($this->similar_artwork != $similar_artwork){
            $this->similar_artwork = $similar_artwork;
            $this->register_a_change("similar_artwork");
            return true;
        }
        return false;
    }

    /**
     * Get path to the artwork image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set path to image
     *
     * @param string $image
     * @return boolean
     */
    public function setImage($image)
    {
        if($this->image != $image){
            $this->image = $image;
            $this->register_a_change("image");
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
