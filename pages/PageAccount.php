<?php
require_once 'Page.php';

/**
 * Class PageAccount
 *
 * Page ccount
 */
class PageAccount extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = 'Account Details';

    /**
     * Name of the page
     */
    public const NAME = 'Account';

    /**
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        return $this->accountDetails();
    }

    /**
     * Get Account Details Section
     *
     * @return string
     */
    function accountDetails(){

        $first_name = !empty($_POST['userform_first_name']) ? $_POST['userform_first_name'] : '';
        $last_name  = !empty($_POST['userform_last_name'])  ? $_POST['userform_last_name']  : '';
        $username   = !empty($_POST['userform_username'])   ? $_POST['userform_username']   : '';
        $password   = !empty($_POST['userform_password'])   ? $_POST['userform_password']   : '';
        $address1   = !empty($_POST['userform_address1'])   ? $_POST['userform_address1']   : '';
        $address2   = !empty($_POST['userform_address2'])   ? $_POST['userform_address2']   : '';
        $city       = !empty($_POST['userform_city'])       ? $_POST['userform_city']       : '';
        $state      = !empty($_POST['userform_state'])      ? $_POST['userform_state']      : '';
        $zip_code   = !empty($_POST['userform_zip'])        ? $_POST['userform_zip']        : '';


        $output = '';


        $output .= '<div style="margin-bottom: 50px;"><a href="index.php?page=order-history">Order History</a></div>';


        $output .= '<form class="userForm" action="index.php?page=account" method="POST">';

        $output .= '<h4 class="userForm-header">Account Details</h4>';

        $output .= '<label for="userFormFirstName"  class="form-label" >First Name</label>';
        $output .= '<input id="userFormFirstName" name="userform_first_name" type="text" value="'.$first_name.'" class="form-input" />';

        $output .= '<label for="userFormLastName"  class="form-label" >Last Name</label>';
        $output .= '<input id="userFormLastName" name="userform_last_name" type="text" value="'.$last_name.'" class="form-input" />';

        $output .= '<label for="userFormUsername"  class="form-label" >Username</label>';
        $output .= '<input id="userFormUsername" name="userform_username" type="text" value="'.$username.'" class="form-input" />';

        $output .= '<label for="userFormPassword"  class="form-label" >Password</label>';
        $output .= '<input id="userFormPassword" name="userform_password" type="password" value="'.$password.'" class="form-input" />';

        $output .= '<label for="userFormAddress1"  class="form-label" >Address</label>';
        $output .= '<input id="userFormAddress1" name="userform_address1" type="text" value="'.$address1.'" class="form-input" />';
        $output .= '<input id="userFormAddress2" name="userform_address2" type="text" value="'.$address2.'" class="form-input" />';

        $output .= '<label for="userFormCity"  class="form-label" >City</label>';
        $output .= '<input id="userFormCity" name="userform_city" type="text" value="'.$city.'" class="form-input" />';

        $output .= '<label for="userFormState"  class="form-label" >State</label>';
        $output .= '<input id="userFormState" name="userform_state" type="text" value="'.$state.'" class="form-input" />';

        $output .= '<label for="userFormZip"  class="form-label" >Zip Code</label>';
        $output .= '<input id="userFormZip" name="userform_zip" type="text" value="'.$zip_code.'" class="form-input" />';

        $output .= '<input type="hidden" value="account" name="page" />';
        $output .= '<input type="submit" value="Save Changes" name="userform_submit" class="form-submit" >';
        $output .= '</form>';

        return $output;
    }
}