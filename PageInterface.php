<?php

/**
 * Interface PageInterface
 */
interface PageInterface {

    /**
     * Get Name
     *
     * @return mixed
     */
    public static function getName();

    /**
     * Get <head> tag contents
     *
     * @return mixed
     */
    public function getHead();

    /**
     * Get title of the page
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * Get <body> tag contents
     *
     * @return mixed
     */
    public function getBody();
}