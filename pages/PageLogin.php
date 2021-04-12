<?php
require_once 'Page.php';

/**
 * Class PageLogin
 *
 * Login/Registration page
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

    public function __construct() {
        parent::__construct();
    }

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

      $html .= '<form method="post" action="index.php?page=login" class="login-form">';

      $html .= '<label for="login_username">Username</label><br />';
      $html .= '<input  id="login_username" name="username" type="text"class="form-input" required ><br /><br />';

      $html .= '<label for="login_password">Password</label><br />';
      $html .= '<input  id="login_password" name="password" type="password" minlength="8" class="form-input" required ><br /><br />';

      $html .= '<input name="page" value="login" type="hidden">';
      $html .= '<button type="submit" class="button">Login</button>';

      $html .= '</form><br /><br />';


      $html .= '<h2>Registration</h2><br /><br />';


      if(!empty($this->message)){
        $html .= '<p style="color:red" >' .$this->message.'</p><br>';
      }

      $html .= '<form method="post" action="index.php?page=registration" class="registration-form">';

      $html .= '<label for="registration_fullname">Full name</label><br />';
      $html .= '<input  id="registration_fullname" name="fullname" type="text" class="form-input" required value="'.(!empty($_POST['fullname']) ? $_POST['fullname']: '').'" ><br /><br />';

      $html .= '<label for="registration_address">Address</label><br />';
      $html .= '<input  id="registration_address" name="address" type="text" class="form-input" required value="'.(!empty($_POST['address']) ? $_POST['address']: '').'"><br /><br />';

      $html .= '<label for="registration_username">Username</label><br />';
      $html .= '<input  id="registration_username" name="username" class="form-input" required type="text"><br /><br />';

      $html .= '<label for="registration_password">Password</label><br />';
      $html .= '<input  id="registration_password" name="password" class="form-input"  type="password" minlength="8" required><br /><br />';

      $html .= '<input name="page" value="registration" type="hidden">';
      $html .= '<button type="submit" class="button">Sign Up</button>';

      $html .= '</form>';

      return $html;
    }
}
