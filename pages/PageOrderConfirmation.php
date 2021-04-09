<?php
require_once 'Page.php';

/**
 * Class PageOrderConfirmation
 *
 * Order Confirmation
 */
class PageOrderConfirmation extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = 'Order Confirmation';

    /**
     * Name of the page
     */
    public const NAME = 'OrderConfirmation';

    /**
     * Cart Items
     */
    public $order = [];

    /**
     * Order Number
     */
    public $order_number = null;

    /**
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        // First Version of the about us page
        $output = '';
        $output .= '<h2>Order Placed</h2><br /><br />';

        $output .= '<h3>Order# '.$this->getOrderNumber().'</h3><br><br>';


        $output .= $this->getCartItems() .'<br><br>';


        $output .= '<p><a href="index.php?page=order-history">Order Histhory</a></p>';

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
        $output .= '</tr></thead><tbody>';

        if(!empty($this->order) && is_array($this->order) && count($this->order)){

            foreach($this->order as $k => $cart_item){
                $output .= '<tr>';
                $output .= '<td><a href="index.php?page=artwork&id='.(int)$cart_item["oi_artwork"].'" >'.$cart_item["artwork_name"].'</a></td>';

                $output .= '<td>'.$cart_item["oi_quantity"].'</td>';

                $output .= '<td>'.$cart_item["oi_shippingAddr"].'</td>';

                $output .= '</tr>';
            }

        } else {
            $output .= '<tr><td>No items yet.</td></tr>';
        }
        $output .= '</tbody></table><br><br>';
        return $output;
    }

    public function setOrder($order){
        $this->order = $order;
    }

    public function setOrderNumber($order_number){
        $this->order_number = $order_number;
    }

    public function getOrderNumber(){
        return $this->order_number;
    }

    public function getOrder(){
        return $this->order;
    }
}
