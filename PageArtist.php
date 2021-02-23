<?php
require_once 'Page.php';
require_once 'Artist.php';

class PageArtist extends Page
{
    public $title = 'Artist';
    public const NAME = 'Artist';

    public $artist;

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
  </article>
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