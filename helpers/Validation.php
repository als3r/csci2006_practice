<?php
define('MIN_DATE_ALLOWED', '1999-01-01');
define('MAX_DATE_ALLOWED', '2010-12-31');
define('DATE_FORMAT', 'Y-m-d');

class Validation
{
    /**
     * Checks if a post string is a positive number
     *
     * @param $post
     * @return bool
     */
    public static function is_post_number_positive($post)
    {
        return is_numeric($post) && $post > 0;
    }

    /**
     * Checks if a post string is an email address
     *
     * @param $post
     * @return mixed
     */
    public static function is_post_email_valid($post)
    {
        return filter_var($post, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Checks if a post string is a phone number
     *
     * @param $post
     * @return bool
     */
    public static function is_post_phone_number_valid($post)
    {
        if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $post)) {

            return true;
        }
        return false;
    }

    /**
     * Checks if a post string is a date and is within the date range
     *
     * @param $post
     * @return bool
     */
    public static function is_post_date_valid($post){
        $datetime = DateTime::createFromFormat(DATE_FORMAT, $post);
        if(! $datetime){
            return false;
        }

        $min_date = DateTime::createFromFormat(DATE_FORMAT, MIN_DATE_ALLOWED);
        $max_date = DateTime::createFromFormat(DATE_FORMAT, MAX_DATE_ALLOWED);
        if($datetime >= $min_date && $datetime <= $max_date){
            return true;
        }
        return false;
    }
}