<?php
require_once 'Page.php';

/**
 * Class PageAboutUs
 *
 * About Us page
 */
class PageCart extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = 'Cart';

    /**
     * Name of the page
     */
    public const NAME = 'Cart';


    /**
    * Cart Items
    */
    public $cart_items = [];

    /**
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        // First Version of the about us page
        $output = '';
        $output .= '<h2>Cart</h2><br /><br />';
        $output .= $this->getCartItems();
        return $output;
    }

    /**
    * Display Cart Items
    */
    public function getCartItems(){

      $output = '<table>';
      $output .= '<thead><tr>';
      $output .= '<th>Artwork</th>';
      $output .= '<th>Quantity</th>';
      $output .= '<th>Shipping Address</th>';
      $output .= '</tr></thead><tbody>';

      if(!empty($this->cart_items) && is_array($this->cart_items) && count($this->cart_items)){

        foreach($this->cart_items as $k => $cart_item){
            $output .= '<tr>';
            $output .= '<td><a href="index.php?page=artwork&id='.$cart_item["oi_artwork"].'" >'.$cart_item["artwork_name"].'</a></td>';
            $output .= '<td>'.$cart_item["oi_quantity"].'</td>';
            $output .= '<td>'.$cart_item["oi_shippingAddr"].'</td>';
            $output .= '</tr>';
        }

      } else {
        $output .= '<tr><td>No items yet.</td></tr>';
      }
      $output .= '</tbody></table>';
      return $output;
    }

    public function setCartItems($cart_items){
      $this->cart_items = $cart_items;
    }
}
