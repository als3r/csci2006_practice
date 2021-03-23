<?php
require_once 'Page.php';
require_once 'models\Artwork.php';

class PageArtworks extends Page
{
    public $title = 'Artworks';
    public const NAME = 'Artworks';

    public $artworks = null;

    /**
     * Get Artwork
     */
    public function getArtworks()
    {
        return $this->artworks;
    }

    /**
     * Set Artwork
     */
    public function setArtworks($artworks)
    {
        $this->artworks = $artworks;
    }

    public function getMain()
    {
        $output = '';
        $output .= $this->getMainArticleSection();
        return $output;
    }

    /**
     * Get main article section;
     */
    function getMainArticleSection(){
        $html = '
          <article class="artwork">
            <h2 class="art_title">Artworks</h2>
            <ul class="artwork-list">
              '.$this->getArtworksList().'
            </ul>  
          </article>
          ';
        return $html;
    }

    /**
     * Get contents of artworks list;
     */
    function getArtworksList(){

        $html = '';
        if(is_array($this->getArtworks()) && count($this->getArtworks())){
            foreach ($this->getArtworks() as $k => $row){
                $html .= '<li class="artworks-list__item-link">';
                $html .= '<a class="artworks-list__item-link" href="index.php?page=artwork&id='.(int) $row['id'] .'" >'.$row['name'].'</a>';
                $html .= '</li>';
            }
        }
        return $html;
    }
}