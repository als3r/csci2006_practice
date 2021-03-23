<?php
require_once 'Page.php';
require_once 'models/Artist.php';

class PageArtists extends Page
{
    public $title = 'Artists';
    public const NAME = 'Artist';

    public $artists;

    /**
     * Get Artist
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * Set Artist
     */
    public function setArtists($artists = [])
    {
        $this->artists = $artists;
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
          <article class="artists">
            <h2 class="art_title">Artists</h2>
            <ul class="artitst-list">
              '.$this->getArtistsList().'
            </ul>  
          </article>
          ';
        return $html;
    }

    /**
     * Get contents of related items section;
     */
    function getArtistsList(){

        $html = '';
        if(is_array($this->getArtists()) && count($this->getArtists())){
            foreach ($this->getArtists() as $k => $row){
                $html .= '<li class="artists-list__item-link">';
                $html .= '<a class="artists-list__item-link" href="index.php?page=artist&id='.(int) $row['id'] .'" >'.$row['name'].'</a>';
                $html .= '</li>';
            }
        }
        return $html;
    }
}