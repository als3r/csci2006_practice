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
    public const MENU_TOP = [
        'My Account'    => 'index.php?page=account',
        'Wish List'     => '#',
        'Shopping Cart' => '#',
    ];

    /**
     * Main Menu array
     *
     * Link Title => Link
     */
    public const MENU_MAIN = [
        'Home'      => 'index.php',
        'About Us'  => 'index.php?page=about-us',
        'Art Works' => 'index.php?page=artwork',
        'Artists'   => 'index.php?page=artist',
    ];

    /**
     * Page Title
     *
     * @var string
     */
    public $title;

    /**
     * Name of the class
     */
    public const NAME = 'Page';

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
        return $this->getHead() . $this->getBody();
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
        $output = '<!DOCTYPE html>
          <html lang="en">
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>' . $this->getTitle() . '</title>
              <link rel="stylesheet" href="_aux/default.css">
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
        foreach (self::MENU_TOP as $title => $link ){
            $output .= '<li><a href="'.$link.'">'.$title.'</a></li>';
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
        foreach (self::MENU_MAIN as $title => $link){
            $output .= '<li><a href="'.$link.'">'.$title.'</a></li>';
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
}