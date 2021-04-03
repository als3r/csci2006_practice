<?php
require_once 'Page.php';
require_once 'models/Artwork.php';

class PageArtwork extends Page
{
    public $title;
    public const NAME = 'Artwork';

    public $artwork = null;

    /**
     * Get Artwork
     */
    public function getArtwork()
    {
        return $this->artwork;
    }

    /**
     * Set Artwork
     */
    public function setArtwork(Artwork $artwork)
    {
        $this->artwork = $artwork;
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
      <h2 class="art_title">'.$this->getArtwork()->getArtworkName().'</h2>
      <p class="artist">By <a href="index.php?page=artist&id='.(int) $this->getArtwork()->getArtist()->getId().'">'.$this->getArtwork()->getArtist()->getFullName().'</a></p>
      <figure><img width="458" src="artwork/medium/'.$this->getArtwork()->getArtworkId().'.png" alt="Image of '.$this->getArtwork()->getArtworkName().'" title="'.$this->getArtwork()->getArtworkName().'"></figure>
      <p>'.$this->getArtwork()->getArtworkDescription().'</p>
      <p class="list_price">$'.number_format($this->getArtwork()->getArtworkReprintPrice(),2).'</p>
      <div class="actions">'.(self::isLoggedIn() ? '<a href="#">Add to Wish List</a>': '').'<a href="#">Add to Shopping Cart</a></div>
      <table class="artwork_info">
          <caption>Product Details</caption>
          <tbody>
             '.$this->getFacetsSection().'
             '.$this->getLocationSection().'
             <tr>
                <td class="facet">Genres:</td>
                <td class="value">'.$this->getGenresSection().'</td>
             </tr>
             <tr>
                  <td class="facet">Subjects:</td>
                  <td class="value">'.$this->getSubjectsSection().'</td>
              </tr>
          </tbody>
      </table>
  </article>
  ';
        return $html;
    }

    /**
     * Get contents of related items section;
     */
    function getRelatedItemsSection(){
        $html = '<h2>Smilar ArtWork</h2>';
        $html .= '<article class="related">
      <div class="relatedArt">
          <figure><img src="artwork/small/293.jpg" alt="Still Life with Flowers in a Glass Vase" title="Still Life with Flowers in a Glass Vase">
              <figcaption>
                  <p><a href="#293">Still Life with Flowers in a Glass Vase</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a>'.(self::isLoggedIn() ? '<a href="#">Wish</a>' : '').'<a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/183.jpg" alt="Portrait of Alida Christina Assink" title="Portrait of Alida Christina Assink">
              <figcaption>
                  <p><a href="#183">Portrait of Alida Christina Assink</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a>'.(self::isLoggedIn() ? '<a href="#">Wish</a>' : '').'<a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/820.jpg" alt="Self-portrait" title="Self-portrait">
              <figcaption>
                  <p><a href="#820">Self-portrait</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a>'.(self::isLoggedIn() ? '<a href="#">Wish</a>' : '').'<a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/374.jpg" alt="William II, Prince of Orange, and his Bride, Mary Stuart" title="William II, Prince of Orange, and his Bride, Mary Stuart">
              <figcaption>
                  <p><a href="#374">William II, Prince of Orange, and his Bride, Mary Stuart</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a>'.(self::isLoggedIn() ? '<a href="#">Wish</a>' : '').'<a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/849.jpg" alt="Milkmaid" title="Milkmaid">
              <figcaption>
                  <p><a href="#849">Milkmaid</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a>'.(self::isLoggedIn() ? '<a href="#">Wish</a>' : '').'<a href="#">Cart</a></div>
      </div>
  </article>';
        return $html;
    }


    /**
     * Get contents of artwork facets;
     */
    function getFacetsSection(){

        $html = '';
        if(
            $this->getArtwork()->getFacets() !== null &&
            is_array($this->getArtwork()->getFacets()) &&
            count($this->getArtwork()->getFacets())
        ){
            foreach ($this->getArtwork()->getFacets() as $k => $facet){
                $html .= '<tr>';
                $html .= '<td class="facet">'.$facet["key"].':</td>';
                $html .= '<td class="value">'.$facet["value"].'</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td class="facet">Facet:</td>';
            $html .= '<td class="value">-</td>';
            $html .= '</tr>';
        }
        return $html;
    }

    /**
     * Get contents of artwork subjects;
     */
    function getGenresSection(){

        $html = '';
        if(
            $this->getArtwork()->getGenres() !== null &&
            is_array($this->getArtwork()->getGenres()) &&
            count($this->getArtwork()->getGenres())
        ){
            foreach ($this->getArtwork()->getGenres() as $k => $genre){
                $html .= '<a href="#">'.$genre["key"].'</a> ';
            }
        } else {
            $html = 'Unknown';
        }
        return $html;
    }

    /**
     * Get contents of artwork genres;
     */
    function getSubjectsSection(){

        $html = '';
        if(
            $this->getArtwork()->getSubjects() !== null &&
            is_array($this->getArtwork()->getSubjects()) &&
            count($this->getArtwork()->getSubjects())
        ){
            foreach ($this->getArtwork()->getSubjects() as $k => $subject){
                $html .= '<a href="#">'.$subject["key"].'</a> ';
            }
        } else {
            $html = 'Unknown';
        }
        return $html;
    }

    /**
     * Get contents of artwork location;
     */
    function getLocationSection(){

        $html = '';
        if(
            $this->getArtwork()->getLocation() !== null &&
            $this->getArtwork()->getLocation()->getLocName() !== null
        ){
            $html .= '<tr>';
            $html .= '<td class="facet">Home:</td>';
            $html .= '<td class="value">'.$this->getArtwork()->getLocation()->getLocName().'</td>';
            $html .= '</tr>';
        } else {
            $html .= '<tr>';
            $html .= '<td class="facet">Home:</td>';
            $html .= '<td class="value">Unknown</td>';
            $html .= '</tr>';
        }
        return $html;
    }
}
