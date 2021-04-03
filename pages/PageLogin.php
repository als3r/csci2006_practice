<?php
require_once 'Page.php';

/**
 * Class PageAboutUs
 *
 * About Us page
 */
class PageLogin extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = 'Login';

    /**
     * Name of the page
     */
    public const NAME = 'Login';


    public $message = '';

    /**
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
      // First Version of the about us page
      $html = '';
      $html .= '<h2>Login</h2><br /><br />';

      $html .= '<form method="post" action="index.php?page=login" >';

      // $html .= '<label for="login_fullname">Full name</label><br />';
      // $html .= '<input  id="login_fullname" name="fullname" type="text"><br /><br />';

      $html .= '<label for="login_username">Username</label><br />';
      $html .= '<input  id="login_username" name="username" type="text"><br /><br />';

      $html .= '<label for="login_password">Password</label><br />';
      $html .= '<input  id="login_password" name="password" type="password" min="8"><br /><br />';

      $html .= '<input name="page" value="login" type="hidden">';
      $html .= '<input type="submit" value="Login">';

      $html .= '</form><br /><br />';


      $html .= '<h2>Registration</h2><br /><br />';


      if(!empty($this->message)){
        $html .= '<p style="color:red" >' .$this->message.'</p><br>';
      }

      $html .= '<form method="post" action="index.php?page=registration" >';

      $html .= '<label for="registration_fullname">Full name</label><br />';
      $html .= '<input  id="registration_fullname" name="fullname" type="text"  value="'.(!empty($_POST['fullname']) ? $_POST['fullname']: '').'" ><br /><br />';

      $html .= '<label for="registration_address">Address</label><br />';
      $html .= '<input  id="registration_address" name="address" type="text" value="'.(!empty($_POST['address']) ? $_POST['address']: '').'"><br /><br />';

      $html .= '<label for="registration_username">Username</label><br />';
      $html .= '<input  id="registration_username" name="username" type="text"><br /><br />';

      $html .= '<label for="registration_password">Password</label><br />';
      $html .= '<input  id="registration_password" name="password" type="password" min="8"><br /><br />';

      $html .= '<input name="page" value="registration" type="hidden">';
      $html .= '<input type="submit" value="Sign Up">';

      $html .= '</form>';

      return $html;
    }

    public function setMessage($message = ''){
      $this->message = $message;
    }
}
