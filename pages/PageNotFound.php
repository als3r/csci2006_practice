<?php
require_once 'Page.php';

/**
 * Class PageNotFound
 *
 * Not Found Page
 */
class PageNotFound extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = '404 - Page not found';

    /**
     * Name of the page
     */
    public const NAME = 'NotFound';

    /**
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        // First Version of the about us page
        $output = '';
        $output .= '<h1>404 - Page not found</h1>';
        return $output;
    }
}