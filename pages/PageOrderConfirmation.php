<?php
require_once 'Page.php';

/**
 * Class PageAboutUs
 *
 * About Us page
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
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        // First Version of the about us page
        $output = '';
        $output .= '<h2>Order Confirmation/h2><br /><br />';
        $output .= '<p></p><br /><br />';
        return $output;
    }
}
