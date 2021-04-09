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

        if(self::isLoggedIn()){
            $output .= '<form><button type="submit" class="button">Place Order</button></form>';
        } else {
            if(is_array($this->cart_items) && count($this->cart_items)){
                $output .= '<p>Please use this <a href="index.php?page=login">link</a> to sign up to place an order.</p>';
            }
        }


        return $output;
    }

    /**
    * Display Cart Items
    */
    public function getCartItems(){

      $output = '<table class="table-cart">';
      $output .= '<thead><tr>';
      $output .= '<th>Artwork</th>';
      $output .= '<th>Quantity</th>';
      $output .= '<th>Shipping Address</th>';
      $output .= '<th>Actions</th>';
      $output .= '</tr></thead><tbody>';

      if(!empty($this->cart_items) && is_array($this->cart_items) && count($this->cart_items)){

        foreach($this->cart_items as $k => $cart_item){
            $output .= '<tr>';
            $output .= '<td><a href="index.php?page=artwork&id='.(int)$cart_item["oi_artwork"].'" >'.$cart_item["artwork_name"].'</a></td>';

            $output .= '<td><form action="actions.php" method="post">';
            $output .= '<input type="number" name="quantity" value="'.(int) $cart_item["oi_quantity"].'" class="cart-quantity-input" />';
            $output .= '<input type="hidden" name="artwork_id" value="'.(int) $cart_item["oi_artwork"].'" />';
            $output .= '<input type="hidden" name="action" value="update-quantity-cart" />';
            $output .= '<button type="submit" class="button">Update</button>';
            $output .= '</form></td>';

            $output .= '<td><form action="actions.php" method="post">';
            $output .= '<input type="text" name="address" value="'.$cart_item["oi_shippingAddr"].'" class="cart-address-input" />';
            $output .= '<input type="hidden" name="artwork_id" value="'.(int) $cart_item["oi_artwork"].'" />';
            $output .= '<input type="hidden" name="action" value="update-address-cart" />';
            $output .= '<button type="submit" class="button">Update</button>';
            $output .= '</form></td>';

            $output .= '<td ><a href = "actions.php?action=remove-from-cart&artwork_id=' . $cart_item["oi_artwork"] . '" >Remove</a ></td >';
            $output .= '</tr>';
        }

      } else {
        $output .= '<tr><td>No items yet.</td></tr>';
      }
      $output .= '</tbody></table><br><br>';
      return $output;
    }

    public function setCartItems($cart_items){
      $this->cart_items = $cart_items;
    }
}
