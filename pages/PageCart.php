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
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        // First Version of the about us page
        $output = '';
        $output .= '<h2>Cart</h2><br /><br />';
        $output .= '<p>Welcome to Art Store, your number one source for artwork. We\'re dedicated to providing you the very best of artwork, with an emphasis on quality, fast shipping and handling.</p><br /><br />';
        $output .= '<p>Founded in 2001 by the founders, Artwork Store has come a long way from its beginnings in Saint Paul, MN. When the founders of the store first started out, their passion for eco-friendly paintings drove them to start their own business.</p><br /><br />';
        $output .= '<p>We hope you enjoy our products as much as we enjoy offering them to you. If you have any questions or comments, please don\'t hesitate to contact us.</p><br /><br />';
        $output .= '<p>Sincerely, the founders of Artwork Store</p>';
        return $output;
    }
}
