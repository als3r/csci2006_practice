<?php
require_once 'Page.php';

/**
 * Class PageError
 *
 * About Us page
 */
class PageError extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = 'Error';

    /**
     * Name of the page
     */
    public const NAME = 'Error';

    /*
     * Error Message
     */
    private $error_message = '';

    /**
     * Get Error Message
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * Set Error message
     *
     * @param string $error_message
     * @return bool
     */
    public function setErrorMessage($error_message = '')
    {
        $this->error_message = $error_message;
        return true;
    }

    /**
     * Get Main section
     *
     * @return string
     */
    public function getMain($error_message = '')
    {
        $output = '<p>' . $this->getErrorMessage() . '</p>';
        return $output;
    }
}