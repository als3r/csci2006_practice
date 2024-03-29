<?php
require_once 'PageInterface.php';

/**
 * Class Page implements Page Interface
 *
 * Base class for a page
 */
class Page implements PageInterface
{
    /**
     * Site name
     */
    public const SITE_NAME = 'Art Store';

    /**
     * Top Menu array
     *
     * Link Title => Link
     */
    public const MENU_TOP_VISITOR = [
        'Shopping Cart'     => 'index.php?page=' . PAGE_CART,
        'Sign-in / Sign-up' => 'index.php?page=' . PAGE_LOGIN,
    ];

    /**
     * Top Menu array
     *
     * Link Title => Link
     */
    public const MENU_TOP_CUSTOMER = [
        'My Account'    => 'index.php?page=' . PAGE_ACCOUNT,
        'Order History' => 'index.php?page=' . PAGE_ORDER_HISTORY,
        'Wish List'     => 'index.php?page=' . PAGE_WISHLIST,
        'Shopping Cart' => 'index.php?page=' . PAGE_CART,
        'Logout'        => 'index.php?page=' . PAGE_LOGOUT
    ];

    /**
     * Main Menu array
     *
     * Link Title => Link
     */
    public const MENU_MAIN = [
        'Home' => 'index.php',
        'About Us' => 'index.php?page=about-us',
        'Art Works' => 'index.php?page=artwork',
        'Artists' => 'index.php?page=artist',
    ];

    /**
     * Page Title
     *
     * @var string
     */
    public $title;

    /**
     * Error Message
     *
     * @var string
     */
    public $errorMessage = '';

    /**
     * Name of the class
     */
    public const NAME = 'Page';

    public function __construct() {

    }

    /**
     * Get Name of the object
     */
    public static function getName()
    {
        return self::NAME;
    }

    /**
     * Get Title of the page
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Title of the page
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get full page contents
     */
    public function getPage()
    {
        $output = '';
        $output .= $this->getDoctype();
        $output .= $this->getOpenHtmlTag();
        $output .= $this->getHead();
        $output .= $this->getBody();
        $output .= $this->getCloseHtmlTag();
        return $output;
    }

    /**
     * Prints full page contents
     */
    public function displayPage()
    {
        echo $this->getPage();
        exit;
    }


    /**
     * Get contents of the head tag
     */
    public function getHead()
    {
        $output = '
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>' . $this->getTitle() . '</title>
              <link rel="stylesheet" href="_aux/default.css">
              <!-- Fonts -->
              <link href="http://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet" type="text/css">
              <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
          </head>';
        return $output;
    }

    /**
     * Get contents of the body tag
     */
    public function getBody()
    {
        $output = '<body>';
        $output .= $this->getHeader();
        $output .= '<main>';
        $output .= $this->getErrorMessage();
        $output .= $this->getMain();
        $output .= '</main>';
        $output .= $this->getFooter();
        $output .= '</body>';
        return $output;
    }

    /**
     * Get contents of the main block
     */
    public function getMain()
    {
        return '';
    }

    /**
     * Get contents of the header
     */
    public function getHeader()
    {
        $output = '<header>
        ' . $this->getNavigationTop() . '
        <h1><a href="index.php">' . self::SITE_NAME . '</a></h1>
        ' . $this->getNavigationMain() . '
        </header>';
        return $output;
    }

    /**
     * Get contents of the top navigation block
     */
    public function getNavigationTop()
    {
        $output = '<nav class="user"><ul>';
        if(! User::isLoggedIn() || USER::getUserRole() == USER::ROLE_VISITOR){
          foreach (self::MENU_TOP_VISITOR as $title => $link) {
              $output .= '<li><a href="' . $link . '">' . $title . '</a></li>';
          }
        } else if (User::isLoggedIn() && USER::getUserRole() == USER::ROLE_CUSTOMER) {
          foreach (self::MENU_TOP_CUSTOMER as $title => $link) {
              $output .= '<li><a href="' . $link . '">' . $title . '</a></li>';
          }
        }
        $output .= '</ul></nav>';
        return $output;
    }

    /**
     * Get contents of the main navigation block
     */
    public function getNavigationMain()
    {
        $output = '<nav><ul>';
        foreach (self::MENU_MAIN as $title => $link) {
            $output .= '<li><a href="' . $link . '">' . $title . '</a></li>';
        }
        $output .= '</ul></nav>';
        return $output;
    }

    /**
     * Get contents of the footer block
     */
    public function getFooter()
    {
        $output = '<footer>';
        $output .= '<p>All images are copyright to their owners. This is just a hypothetical site ©2020 Copyright Art Store</p>';
        $output .= '</footer>';
        return $output;
    }

    /**
     * Get Doctype
     *
     * @return string
     */
    public function getDoctype()
    {
        return '<!DOCTYPE html>';
    }

    /**
     * Get Open HTML tag
     *
     * @return string
     */
    public function getOpenHtmlTag()
    {
        return '<html lang="en">';
    }

    /**
     * Get Doctype
     *
     * @return string
     */
    public function getCloseHtmlTag()
    {
        return '</html>';
    }


    /**
    * Checks if user is logged in
    */
    public static function isLoggedIn(){
      if(isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] === true){
        return true;
      }
      return false;
    }

    public function getErrorMessage(){
        if(!empty($this->errorMessage)){
            $output = '<div class="error-message-container"><p class="error-message">'.$this->errorMessage.'</p></div>';
            $this->errorMessage = '';
            return $output;
        }
    }

    public function setErrorMessage($message){
        $this->errorMessage = $message;
    }
}
