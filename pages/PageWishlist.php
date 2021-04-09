<?php
require_once 'Page.php';

/**
 * Class PageAboutUs
 *
 * About Us page
 */
class PageWishlist extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = 'Wishlist';

    /**
     * Name of the page
     */
    public const NAME = 'Wishlist';


    public $wishlist = [];

    /**
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        // First Version of the about us page
        $output = '';
        $output .= '<h2>Wishlist</h2><br /><br />';
        $output .= $this->getWishlist();
        return $output;
    }


    public function getWishlist(){

      $output = '<table>';
      $output .= '<thead><tr><th>Artwork</th></tr></thead>';
      $output .= '<tbody>';

      if(!empty($this->wishlist) && is_array($this->wishlist) && count($this->wishlist)){

        foreach($this->wishlist as $k => $wishlist_item){
            $output .= '<tr><td><a href="index.php?page=artwork&id='.$wishlist_item["wl_artwork"].'" >'.$wishlist_item["artwork_name"].'</a></td></tr>';
        }

      } else {
        $output .= '<tr><td>No items yet.</td></tr>';
      }
      $output .= '</tbody></table>';
      return $output;
    }

    public function setWishlistItems($items){
      $this->wishlist = $items;
    }
}
