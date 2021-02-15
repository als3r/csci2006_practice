<?php

  $page = isset($_GET['page']) && in_array($_GET['page'], [
      'artwork',
      'account'
    ])? $_GET['page'] : 'artwork';

  echo getPage($page);

  exit;

/**
* Get full page contents
*/
function getPage($page = 'artwork'){

  $output = '';
  $output .= getHead($page);
  $output .= getBody($page);
  return $output;
}

/**
* Get contents of the head tag
*/
function getHead($page){
  $head = '
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>' . getTitle($page) . '</title>
      <link rel="stylesheet" href="_aux/default.css">
  </head>
  ';
  return $head;
}

/**
* Get Title of the page
*/
function getTitle($page){
  if($page == 'artwork'){
    return 'Lebrun - Self-portrait in a Straw Hat';
  } else if($page == 'account') {
    return 'Account Details';
  } else {
    return '';
  }
}

/**
* Get contents of the body tag
*/
function getBody($page = ''){
  $body  = '<body>';
  $body .= getHeader();

  $body .= '<main>';

  if($page == 'account'){

    $body .= accountDetails();

  } elseif ($page == 'artwork'){

    $body .= getMainArticleSection();
    $body .= '<h2>Similar Artwork</h2>';
    $body .= getRelatedItemsSection();

  }

  $body .= '</main>';

  $body .= getFooter();
  $body .= '</body>';
  $body .= '</html>';
  return $body;
}

/**
* Get contents of the header
*/
function getHeader() {
  $header = '<header>
      <nav class="user">
          <ul>
              <li><a href="index.php?page=account">My Account</a></li>
              <li><a href="#">Wish List</a></li>
              <li><a href="#">Shopping Cart</a></li>
          </ul>
      </nav>
      <h1>Art Store</h1>
      <nav>
          <ul>
              <li><a href="index.php?page=artwork">Home</a></li>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Art Works</a></li>
              <li><a href="#">Artists</a></li>
          </ul>
      </nav>
  </header>';
  return $header;
}

/**
* Get main article section;
*/
function getMainArticleSection(){
  $html = '
  <article class="artwork">
      <h2 class="art_title">Self-portrait in a Straw Hat</h2>
      <p class="artist">By <a href="#">Louise Elisabeth Lebrun</a></p>
      <figure><img src="artwork/medium/13.jpg" alt="Self-portrait in a Straw Hat" title="Self-portrait in a Straw Hat">
          <figcaption>
              <p>The painting appears, after cleaning, to be an autograph replica of a picture, the original of which was painted in Brussels in 1782 in free imitation of Rubens’s ’Chapeau de Paille’, which LeBrun had seen in Antwerp. It was
                  exhibited in Paris in 1782 at the Salon de la Correspondance. LeBrun’s original is recorded in a private collection in France.</p>
              <p class="list_price">$700</p>
              <div class="actions"><a href="#">Add to Wish List</a><a href="#">Add to Shopping Cart</a></div>
              <table class="artwork_info">
                  <caption>Product Details</caption>
                  <tbody>
                      <tr>
                          <td class="facet">Date:</td>
                          <td class="value">1782</td>
                      </tr>
                      <tr>
                          <td class="facet">Medium:</td>
                          <td class="value">Oil on canvas</td>
                      </tr>
                      <tr>
                          <td class="facet">Dimension:</td>
                          <td class="value">98cm x 71cm</td>
                      </tr>
                      <tr>
                          <td class="facet">Home:</td>
                          <td class="value"><a href="#">National Gallery, London</a></td>
                      </tr>
                      <tr>
                          <td class="facet">Genres:</td>
                          <td class="value"><a href="#">Realism</a>, <a href="#">Rococo</a></td>
                      </tr>
                      <tr>
                          <td class="facet">Subjects:</td>
                          <td class="value"><a href="#">People</a>, <a href="#">Arts</a></td>
                      </tr>
                  </tbody>
              </table>
          </figcaption>
      </figure>
  </article>
  ';
  return $html;
}

/**
* Get contents of related items section;
*/
function getRelatedItemsSection(){
  $html = '<article class="related">
      <div class="relatedArt">
          <figure><img src="artwork/small/293.jpg" alt="Still Life with Flowers in a Glass Vase" title="Still Life with Flowers in a Glass Vase">
              <figcaption>
                  <p><a href="#293">Still Life with Flowers in a Glass Vase</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/183.jpg" alt="Portrait of Alida Christina Assink" title="Portrait of Alida Christina Assink">
              <figcaption>
                  <p><a href="#183">Portrait of Alida Christina Assink</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/820.jpg" alt="Self-portrait" title="Self-portrait">
              <figcaption>
                  <p><a href="#820">Self-portrait</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/374.jpg" alt="William II, Prince of Orange, and his Bride, Mary Stuart" title="William II, Prince of Orange, and his Bride, Mary Stuart">
              <figcaption>
                  <p><a href="#374">William II, Prince of Orange, and his Bride, Mary Stuart</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
      <div class="relatedArt">
          <figure><img src="artwork/small/849.jpg" alt="Milkmaid" title="Milkmaid">
              <figcaption>
                  <p><a href="#849">Milkmaid</a></p>
              </figcaption>
          </figure>
          <div class="actions"><a href="#">View</a><a href="#">Wish</a><a href="#">Cart</a></div>
      </div>
  </article>';
  return $html;
}

/**
* Get contents of the footer;
*/
function getFooter(){
  $footer = '<footer>
      <p>All images are copyright to their owners. This is just a hypothetical site ©2020 Copyright Art Store</p>
  </footer>';
  return $footer;
}


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
?>
