<?php
require_once 'Page.php';

/**
 * Class PageOrderHistory
 *
 * About Us page
 */
class PageOrderHistory extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = 'Order History';

    /**
     * Name of the page
     */
    public const NAME = 'Order History';


    /**
    * Cart Items
    */
    public $orders = [];

    /**
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        // First Version of the about us page
        $output = '';
        $output .= '<h2>Order History</h2><br /><br />';
        $output .= $this->getOrders();

        if(self::isLoggedIn()){
            $output .= '<form><button type="submit" class="button">Place Order</button></form>';
        } else {
            if(is_array($this->orders) && count($this->orders)){
                $output .= '<p>Please use this <a href="index.php?page=login">link</a> to sign up to place an order.</p>';
            }
        }


        return $output;
    }

    /**
    * Display Cart Items
    */
    public function getOrders(){


      $output = '';

      if(!empty($this->orders) && is_array($this->orders) && count($this->orders)){

        foreach($this->orders as $order_num => $order){

            $output .= '<table class="table-cart">';
            $output .= '<caption style="text-align: left; font-weight: bold;">Order# '.$order_num.'</caption>';
            $output .= '<thead><tr>';
            $output .= '<th style="width:450px;">Artwork</th>';
            $output .= '<th style="width:50px;">Quantity</th>';
            $output .= '<th style="width:400px;">Shipping Address</th>';
            $output .= '</tr></thead><tbody>';

            foreach ($order as $artwork_id => $cart_item){
                $output .= '<tr>';
                $output .= '<td><a href="index.php?page=artwork&id='.(int)$cart_item["oi_artwork"].'" >'.$cart_item["artwork_name"].'</a></td>';

                $output .= '<td>'.(int) $cart_item["oi_quantity"].'</td>';

                $output .= '<td>'.$cart_item["oi_shippingAddr"].'</td>';

                $output .= '</tr>';
            }

            $output .= '</tbody></table><br><br>';
        }

      } else {
        $output .= '<p>>No Orders yet.</p><br>';
      }
      return $output;
    }

    public function setOrders($orders){
      $this->orders = $orders;
    }
}
