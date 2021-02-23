<?php
require_once 'Page.php';
require_once 'Artwork.php';
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
      <h2 class="art_title">'.$this->getArtwork()->getTitle().'</h2>
       <p class="artist">By <a href="index.php?page=artist&id='.(int) $this->getArtwork()->getArtistid().'">'.$this->getArtwork()->getArtistName().'</a></p>
      <figure><img width="458" src="artwork/medium/'.$this->getArtwork()->getImage().'" alt="Image of '.$this->getArtwork()->getTitle().'" title="'.$this->getArtwork()->getTitle().'"></figure>
      <p>'.$this->getArtwork()->getDescription().'</p>
      <p class="list_price">'.$this->getArtwork()->getPriceFormatted().'</p>
      <div class="actions"><a href="#">Add to Wish List</a><a href="#">Add to Shopping Cart</a></div>
      <table class="artwork_info">
          <caption>Product Details</caption>
          <tbody>
              <tr>
                  <td class="facet">Date:</td>
                  <td class="value">'.$this->getArtwork()->getDate().'</td>
              </tr>
              <tr>
                  <td class="facet">Medium:</td>
                  <td class="value">'.$this->getArtwork()->getMedium().'</td>
              </tr>
              <tr>
                  <td class="facet">Dimension:</td>
                  <td class="value">'.$this->getArtwork()->getWidth().'cm x '.$this->getArtwork()->getHeight().'cm</td>
              </tr>
              <tr>
                  <td class="facet">Home:</td>
                  <td class="value"><a href="#">'.$this->getArtwork()->getHome().'</a></td>
              </tr>
              <tr>
                  <td class="facet">Genres:</td>
                  <td class="value"><a href="#">'.$this->getArtwork()->getGenres().'</a></td>
              </tr>
              <tr>
                  <td class="facet">Subjects:</td>
                  <td class="value"><a href="#">'.$this->getArtwork()->getSubjects().'</a></td>
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