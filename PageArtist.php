<?php
require_once 'Page.php';
require_once 'Artist.php';
require_once 'Rating.php';

class PageArtist extends Page
{
    public $title = 'Artist';
    public const NAME = 'Artist';

    public $artist  = null;
    public $rating  = null;

    public $user_id = null;


    public function __construct() {
      $this->rating = new Rating();
      $this->user_id = 11;
    }

    /**
     * Get Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set Artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    public function getMain()
    {
        $output = '';
        $output .= $this->getMainArticleSection();
        $output .= $this->getRelatedItemsSection();
        return $output;
    }

    /**
     * Get main article section;
     */
    function getMainArticleSection(){
        $html = '
  <article class="artwork">
      <h2 class="art_title">'.$this->getArtist()->getFullName().'</h2>
      <p class="artist">'.$this->getArtist()->getImageTitle().'</p>
      <figure><img width="458" src="artwork/medium/'.$this->getArtist()->getImage().'" alt="Image of '.$this->getArtist()->getImageTitle().'" title="'.$this->getArtist()->getImageTitle().'"></figure>
      <p>'.$this->getArtist()->getDescription().'</p>
      <table class="artwork_info">
          <caption>Artist Details</caption>
          <tbody>
              <tr>
                  <td class="facet">Birth Year:</td>
                  <td class="value">'.$this->getArtist()->getYearDeath().'</td>
              </tr>
              <tr>
                  <td class="facet">Death Year:</td>
                  <td class="value">'.$this->getArtist()->getYearDeath().'</td>
              </tr>
              <tr>
                  <td class="facet">Nationality:</td>
                  <td class="value"><a href="#">'.$this->getArtist()->getNationality().'</a></td>
              </tr>
              <tr>
                  <td class="facet">Genres:</td>
                  <td class="value"><a href="#">'.$this->getArtist()->getGenres().'</a></td>
              </tr>
          </tbody>
      </table>
      ' . $this->getRatingSection() . '
  </article>
  ';
        return $html;
    }


    /**
     * Get rating section;
     */
    public function getRatingSection(){

        $avg_rating = $this->rating->getAverageRating($this->artist->getId(), Rating::TYPE_ARTIST);

        $html = '
          <section class="rating-section">
            <h4 class="section-header">Rating</h4>';
            if($avg_rating > 0) {
              $html .= '<div>'.number_format($avg_rating, 2).' of 10 stars</div>';
            } else {
              $html .= '<div class="rating-box">Not Rayted yet</div>';
            }
            $html .= $this->getRatingForm()
            .'
          </section>
        ';

        return $html;
    }


    /**
     * Get rating form;
     */
    function getRatingForm(){

        $avg_rating = $this->rating->getAverageRating($this->artist->getId(), Rating::TYPE_ARTWORK);

        $html = '
          <form class="rating-section" method="post" action="process-rating.php">
            <h4 class="section-header">Rate Artist</h4>
            <label for="rating-form__rating" class="rating-form__label">Select Rating:</label>
            <select id="rating-form__rating" class="rating-form__rating" name="rating_value">';
            for ($i=1; $i <=10 ; $i++) {
              $html.='<option value="'.$i.'">'.$i.'</option>';
            }
        $html.=
            '</select>
            <input type="hidden" name="user_id" value="'.(int) $this->user_id.'" />
            <input type="hidden" name="rating_type" value="'.Rating::TYPE_ARTIST.'" />
            <input type="hidden" name="rating_entity_id" value="'.(int) $this->artist->getId().'" />
            <button type="submit" class="rating-form__submit">Submit</button>
          </section>
        ';

        return $html;
    }


    /**
     * Get contents of related items section;
     */
    function getRelatedItemsSection(){
        $html = '<h2>Featured Artwork</h2>';
        $html .= '<article class="related">
      <div class="relatedArt">
          <figure><img src="artwork/small/293.jpg" alt="Still Life with Flowers in a Glass Vase" title="Still Life with Flowers in a Glass Vase">
              <figcaption>
                  <p><a href="#293">Still Life with Flowers in a Glass Vase</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/183.jpg" alt="Portrait of Alida Christina Assink" title="Portrait of Alida Christina Assink">
              <figcaption>
                  <p><a href="#183">Portrait of Alida Christina Assink</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/820.jpg" alt="Self-portrait" title="Self-portrait">
              <figcaption>
                  <p><a href="#820">Self-portrait</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/374.jpg" alt="William II, Prince of Orange, and his Bride, Mary Stuart" title="William II, Prince of Orange, and his Bride, Mary Stuart">
              <figcaption>
                  <p><a href="#374">William II, Prince of Orange, and his Bride, Mary Stuart</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/849.jpg" alt="Milkmaid" title="Milkmaid">
              <figcaption>
                  <p><a href="#849">Milkmaid</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
  </article>';
        return $html;
    }
}
