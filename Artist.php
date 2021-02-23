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

    /**
     * ID of the artwork
     * @var integer
     */
    private $id;

    /**
     * First Name
     * @var string
     */
    private $first_name;

    /**
     * Middle Name
     * @var string
     */
    private $middle_name;

    /*
     * Last Name
     * @var string
     */
    private $last_name;

    /*
     * Description
     * @var string
     */
    private $description;

    /*
     * Genres
     * @var string
     */
    private $genres;

    /*
     * Нear of the birth of the artist
     * @var string
     */
    private $year_birth;

    /*
     * Нear of the death of the artist
     * @var string
     */
    private $year_death;

    /*
     * Nationality of the artist
     * @var string
     */
    private $nationality;

    /*
     * Title of the image (in case when artist work used as image)
     * @var string
     */
    private $image_title;

    /*
     * Path to the image of the artist or artist's work
     * @var string
     */
    private $image;

    // Data Set
    private $data = [
        1 => [
            "id" => 1,
            "first_name" => "Elisabeth",
            "middle_name" => "Louise",
            "last_name" => "Le Brun",
            "description" => "<p>Élisabeth Louise Vigée Le Brun; 16 April 1755 – 30 March 1842, also known as Madame Le Brun, was a prominent French portrait painter of the late 18th century.</p>
                <p>Her artistic style is generally considered part of the aftermath of Rococo with elements of an adopted Neoclassical style. Her subject matter and color palette can be classified as Rococo, but her style is aligned with the emergence of Neoclassicism. Vigée Le Brun created a name for herself in Ancien Régime society by serving as the portrait painter to Marie Antoinette. She enjoyed the patronage of European aristocrats, actors, and writers, and was elected to art academies in ten cities.</p>
                <p>Vigée Le Brun created some 660 portraits and 200 landscapes. In addition to many works in private collections, her paintings are owned by major museums, such as the Louvre, Hermitage Museum, National Gallery in London, Metropolitan Museum of Art in New York, and many other collections in continental Europe and the United States.</p>",
            "year_birth" => 1755,
            "year_death" => 1842,
            "genres" => "Rococo, Neoclassicism",
            "nationality" => "French",
            "image_title" => "Self-portrait in a Straw Hat",
            "image" => "13.jpg",
        ],
        2 => [
            "id" => 2,
            "first_name" => "Anthony",
            "middle_name" => "",
            "last_name" => "Van Dyck",
            "description" => "<p>Sir Anthony van Dyck (Dutch pronunciation: [vɑn ˈdɛik], many variant spellings; 22 March 1599 – 9 December 1641) was a Flemish Baroque artist who became the leading court painter in England after success in the Southern Netherlands and Italy.</p>
                <p>The seventh child of Frans van Dyck, a wealthy Antwerp silk merchant, Anthony painted from an early age. He was successful as an independent painter in his late teens, and became a master in the Antwerp guild in 1618. By this time he was working in the studio of the leading northern painter of the day, Peter Paul Rubens, who became a major influence on his work. Van Dyck worked in London for some months in 1621, then returned to Flanders for a brief time, before travelling to Italy, where he stayed until 1627, mostly in Genoa. In the late 1620s he completed his greatly admired Iconography series of portrait etchings, mostly of other artists. He spent five years in Flanders after his return from Italy, and from 1630 was court painter for the archduchess Isabella, Habsburg Governor of Flanders. In 1632 he returned to London to be the main court painter, at the request of Charles I of England.</p>
                <p>With the exception of Holbein, van Dyck and his contemporary Diego Velázquez were the first painters of pre-eminent talent to work mainly as court portraitists, revolutionising the genre. He is best known for his portraits of the aristocracy, most notably Charles I, and his family and associates. Van Dyck became the dominant influence on English portrait-painting for the next 150 years. He also painted mythological and biblical subjects, including altarpieces, displayed outstanding facility as a draughtsman, and was an important innovator in watercolour and etching. His superb brushwork, apparently rather quickly painted, can usually be distinguished from the large areas painted by his many assistants. His portrait style changed considerably between the different countries he worked in, culminating in the relaxed elegance of his last English period. His influence extends into the modern period. The Van Dyke beard is named after him. During his lifetime, Charles I granted him a knighthood, and he was buried in St Paul's Cathedral, an indication of his standing at the time of his death.</p>",
            "year_birth" => 1599,
            "year_death" => 1641,
            "genres" => "Baroque",
            "nationality" => "Flemish",
            "image_title" => "William II, Prince of Orange, and his Bride, Mary Stuart",
            "image" => "293.jpg",
        ],
        3 => [
            "id" => 3,
            "first_name" => "Nicolaes",
            "middle_name" => "",
            "last_name" => "Van Verendael",
            "description" => "<p>Nicolaes van Verendael or Nicolaes van Veerendael (Antwerp, 1640 – Antwerp, 1691) was a Flemish painter active in Antwerp who is mainly known for his flower paintings and vanitas still lifes. He was a frequent collaborator of other Antwerp artists to whose compositions he added the still life elements. He also painted a number of singeries, i.e, scenes with monkeys dressed and acting as humans.</p>",
            "year_birth" => 1640,
            "year_death" => 1691,
            "genres" => "Still Life",
            "nationality" => "Flemish",
            "image_title" => "Still Life with Flowers in a Glass Vase",
            "image" => "183.jpg",
        ]
    ];

    // Default Data for a record
    private const DEFAULT_DATA = [
        "id" => null,
        "first_name" => "Default First Name",
        "middle_name" => "",
        "last_name" => "Default Last Name",
        "description" => "Default Description",
        "year_birth" => 0,
        "year_death" => 0,
        "genres" => "Default Genres",
        "nationality" => "Default Nationality",
        "image_title" => "Default Image Title",
        "image" => "default.jpg",
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

        $this->id          = isset($arr["id"])              ? $arr["id"] : null;
        $this->first_name  = isset($arr["first_name"]) ? $arr["first_name"] : '';
        $this->middle_name = isset($arr["middle_name"]) ? $arr["middle_name"] : '';
        $this->last_name   = isset($arr["last_name"]) ? $arr["last_name"] : '';
        $this->description = isset($arr["description"]) ? $arr["description"] : '';
        $this->year_birth  = isset($arr["year_birth"]) ? $arr["year_birth"] : '';
        $this->year_death  = isset($arr["year_death"]) ? $arr["year_death"] : '';
        $this->genres      = isset($arr["genres"]) ? $arr["genres"] : '';
        $this->nationality = isset($arr["nationality"]) ? $arr["nationality"] : '';
        $this->image_title = isset($arr["image_title"]) ? $arr["image_title"] : '';
        $this->image       = isset($arr["image"]) ? $arr["image"] : '';
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
        if (isset($this->data[(int)$id])) {
            return $this->data[(int)$id];
        } else {
            return self::DEFAULT_DATA;
        }
    }


    /**
     * Create a record of artist
     *
     * @return mixed|void
     */
    public function create()
    {
        $values = $this->getArrayOfAttributes();
        // mocking creating a record in db, $created_id - "returned" id from db
        $created_id = rand(100,200);
        $values['id'] = $created_id;
        $this->log("Object Create(type: Artist, id: " . (int) $values['id'] . "): " . printArray($values) . PHP_EOL);
    }


    /**
     * Get record by id
     *
     * @param $id
     * @return mixed|void
     */
    public function retrieveOneById($id)
    {
        $this->log("Start Retireiving Artist by ID " . (int) $id);
        $this->loadData($id);
        $this->log("End Retireiving Artist by ID" . PHP_EOL);
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

        $this->log("Object Edits Saved (type: Artist, id: " . (int) $id . "): Changed attributes: " . $this->printArray($attributes_changed_array));
        $this->log("Object Edits Saved (type: Artist, id: " . (int) $id . "): New Object: " . $this->printArray($values) . PHP_EOL);
    }


    /**
     * Delete record by id
     *
     * @param $id
     * @return mixed|void
     */
    public function deleteOneById($id)
    {
        $this->log("Object Deleted (type: Artist, id: " . (int) $id . ")" . PHP_EOL);
    }


    /**
     * Get all of the attributes in array
     *
     * @return array
     */
    private function getArrayOfAttributes(){
        $array = [];
        $array["id"]          = $this->id;
        $array["first_name"]  = $this->first_name;
        $array["middle_name"] = $this->middle_name;
        $array["last_name"]   = $this->last_name;
        $array["description"] = $this->description;
        $array["year_birth"]  = $this->year_birth;
        $array["year_death"]  = $this->year_death;
        $array["genres"]      = $this->genres;
        $array["nationality"] = $this->nationality;
        $array["image_title"] = $this->image_title;
        $array["image"]       = $this->image;
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
     * Get full name of artist
     *
     * @return string
     */
    public function getFullName()
    {
        $output = $this->first_name;
        $output .= !empty($this->middle_name) ? ' ' . $this->middle_name : '';
        $output .= !empty($this->last_name) ? ' ' . $this->last_name : '';
        return $output;
    }


    /**
     * Get First Name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set First Name
     *
     * @param string $first_name
     * @return boolean
     */
    public function setFirstName($first_name = '')
    {
        if($this->first_name != $first_name){
            $this->first_name = $first_name;
            $this->register_a_change("first_name");
            return true;
        }
        return false;
    }

    /**
     * Get Middle Name
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middle_name;
    }

    /**
     * Set Middle Name
     *
     * @param string $middle_name
     * @return boolean
     */
    public function setMiddleName($middle_name = '')
    {
        if($this->middle_name != $middle_name){
            $this->middle_name = $middle_name;
            $this->register_a_change("middle_name");
            return true;
        }
        return false;
    }

    /**
     * Get Last Name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set Last Name
     *
     * @param string $last_name
     * @return boolean
     */
    public function setLastName($last_name = '')
    {
        if($this->last_name != $last_name){
            $this->last_name = $last_name;
            $this->register_a_change("last_name");
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
        return $this->description;
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return boolean
     */
    public function setDescription($description = '')
    {
        if($this->description != $description){
            $this->description = $description;
            $this->register_a_change("description");
            return true;
        }
        return false;
    }

    /**
     * Get Genres
     *
     * @return string
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Set Genres
     *
     * @param string $genres
     * @return boolean
     */
    public function setGenres($genres = '')
    {
        if($this->genres != $genres){
            $this->genres = $genres;
            $this->register_a_change("genres");
            return true;
        }
        return false;
    }

    /**
     * Get year of birth
     *
     * @return integer
     */
    public function getYearBirth()
    {
        return $this->year_birth;
    }

    /**
     * Set Year of birth
     *
     * @param integer $year_birth
     * @return boolean
     */
    public function setYearBirth($year_birth)
    {
        if($this->year_birth != $year_birth){
            $this->year_birth = $year_birth;
            $this->register_a_change("year_birth");
            return true;
        }
        return false;
    }

    /**
     * Get Year of death
     *
     * @return integer
     */
    public function getYearDeath()
    {
        return $this->year_death;
    }

    /**
     * Set year of death
     *
     * @param integer $year_death
     * @return boolean
     */
    public function setYearDeath($year_death)
    {
        if($this->year_death != $year_death){
            $this->year_death = $year_death;
            $this->register_a_change("year_death");
            return true;
        }
        return false;
    }

    /**
     * Get nationality of artist
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set nationality of artist
     *
     * @param string $nationality
     * @return boolean
     */
    public function setNationality($nationality)
    {
        if($this->nationality != $nationality){
            $this->nationality = $nationality;
            $this->register_a_change("$nationality");
            return true;
        }
        return false;
    }

    /**
     * Get path to image
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
     * Get image title
     *
     * @return string
     */
    public function getImageTitle()
    {
        return $this->image_title;
    }

    /**
     * Set image Title
     *
     * @param string $image_title
     * @return boolean
     */
    public function setImageTitle($image_title)
    {
        if($this->image_title != $image_title){
            $this->image_title = $image_title;
            $this->register_a_change("image_title");
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
