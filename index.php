<?php
require_once 'config.php';
session_start();
$pdo = connect_to_database();

$is_logged_in = User::isLoggedIn();
if(!$is_logged_in){
  User::logInWithDefaultRole();
  $is_logged_in = true;
}

$page_query = !empty($_GET['page']) ? $_GET['page'] : '';
$page_query = !empty($_POST['page']) && $page_query == '' ? $_POST['page'] : $page_query;

if(! in_array($page_query, PAGES)){
  if($page_query == ""){
    $page_query = PAGE_HOME;
  } else {
    $page = new PageNotFound();
    $page->displayPage();
    exit;
  }
}

switch ($page_query) {

  // Artwork page
  case PAGE_ARTIST:

    // test create
    $new_artist = new Artist(null, $pdo);
    $new_artist->setFullName("Test Name");
    $new_artist->setLastName("Test Last Name");
    $new_artist->setBorn(1000);
    $new_artist->setDied(2000);
    $new_artist->setOrigin("Test Origin");
    $new_artist->setInfluence("Test Influence");
    $new_artist->setDescription("Test Description");
    $insert_id = $new_artist->create();

    // test update
    if($insert_id > 0){
      $upd_artist = new Artist($insert_id, $pdo);

      $upd_artist->setFullName("Test Name 2");
      $upd_artist->setLastName("Test Last Name2");
      $upd_artist->setBorn(1333);
      $upd_artist->setDied(1777);
      $upd_artist->setOrigin("Test Origin 2");
      $upd_artist->setInfluence("Test Influence 2");
      $upd_artist->setDescription("Test Description 2");

      $res = $upd_artist->save();
    }

    // test delete
    $is_del = $new_artist->deleteOneById($insert_id);
    // end tests


    // if id param is provided use it, otherwise use random of 1-3
    $artist_id = ! empty($_GET['id']) ? (int) $_GET['id'] : 0;

    if($artist_id > 0){
      // Artist Selected
      $artist = new Artist($artist_id, $pdo);
      $artist->loadData($artist_id);

      // set artist for the page
      if(isset($artist)){
        $page = new PageArtist();
        $page->setArtist($artist);
      } else {
        $page = new PageError();
        $page->setErrorMessage("Error. There are only 3 artists currently. ID: " . (int) $id . " is out of range of 3.");
      }
    } else{
      // List of Artists
      $artists = Artist::getAll($pdo);

      $page = new PageArtists();
      $page->setArtists($artists);
    }
    break;
    // end artist

  // Artist Page
  case PAGE_ARTWORK:

    // test create
    $new_artwork = new Artwork(null, $pdo);
    $new_artwork->setArtworkArtist(1);
    $new_artwork->setArtworkName("Test Name");
    $new_artwork->setArtworkReprintPrice(100);
    $new_artwork->setArtworkLoc(1);
    $new_artwork->setArtworkDescription("Test Description");
    $insert_id = $new_artwork->create();

    // test update
    if($insert_id > 0){
      $upd_artwork = new Artwork($insert_id, $pdo);
      $upd_artwork->setArtworkArtist(2);
      $upd_artwork->setArtworkName("Test Name 2");
      $upd_artwork->setArtworkReprintPrice(200);
      $upd_artwork->setArtworkLoc(2);
      $upd_artwork->setArtworkDescription("Test Description 2");

      $res = $upd_artwork->save();
    }

    // test delete
    $is_del = $new_artwork->deleteOneById($insert_id);
    // end tests

    // if id param is provided use it, otherwise use random of 1-3
    $artwork_id = ! empty($_GET['id']) ? (int) $_GET['id'] : 0;

    if($artwork_id > 0){
      // Artist Selected
      $artwork = new Artwork($artwork_id, $pdo);
      $artwork->loadData($artwork_id);

      $artwork->loadFacets();
      $artwork->loadSubjects();
      $artwork->loadGenres();
      $artwork->loadLocation();
      $artwork->loadArtist();

      $facets   = $artwork->getFacets();
      $subjects = $artwork->getSubjects();
      $genres   = $artwork->getGenres();
      $location = $artwork->getLocation();
      $artist   = $artwork->getArtist();

      // set artist for the page
      if(isset($artwork)){
        $page = new PageArtwork();
        $page->setArtwork($artwork);
      } else {
        $page = new PageError();
        $page->setErrorMessage("Error. Could not find Artwork. ID: " . (int) $id . " is out of range of 3.");
      }
    } else{
      // List of Artworks
      $artworks = Artwork::getAll($pdo);
      $page = new PageArtworks();
      $page->setArtworks($artworks);
    }
    break;
    // end of artworks

  // Account Page
  case PAGE_ACCOUNT:

    if(!User::hasPermission(User::PERMISSION_VIEW_ACCOUNT)){
      $page = new PageNotFound();
      $page->displayPage();
      exit;
    }

    $page = new PageAccount();

    if(!empty($_POST)){

      if(empty($_POST['userform_username'])){
        $page->setErrorMessage('Validation Error. <br>Username cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(empty($_POST['userform_password'])){
        $page->setErrorMessage('Validation Error. <br>Password cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(strlen($_POST['userform_password']) <= 7){
        $page->setErrorMessage('Validation Error. <br>Password must be at least 8 characters.');
        $page->displayPage();
        exit;
      }

      if(empty($_POST['userform_address'])){
        $page->setErrorMessage('Validation Error. <br>Address cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(empty($_POST['userform_full_name'])){
        $page->setErrorMessage('Validation Error. <br>Fullname cannot be empty.');
        $page->displayPage();
        exit;
      }

      $stmt_update = $pdo->prepare("
          UPDATE Customer SET
          customer_username = :customer_username,
          customer_passhash = :customer_passhash, 
          customer_fullName = :customer_fullName, 
          customer_addr     = :customer_addr
          WHERE customer_id = :customer_id
        ");

      $res = $stmt_update->execute([
          ":customer_username" => $_POST['userform_username'],
          ":customer_passhash" => md5($_POST['userform_username'].'SECRET'.$_POST['userform_password']),
          ":customer_fullName" => $_POST['userform_full_name'],
          ":customer_addr"     => $_POST['userform_address'],
          ":customer_id"       => $_SESSION['user']['customer_id'],
      ]);

      if($res){



      } else {
        $page->setErrorMessage('System Error. <br>Cannot update customer details.');
      }

    }


    $stmt = $pdo->prepare("SELECT customer_id, customer_username, customer_fullName, customer_addr FROM Customer WHERE customer_id = :customer_id");
    $stmt->execute([":customer_id" => $_SESSION["user"]["customer_id"]]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    $page->setCustomer($customer);
    break;

  // About Us Page
  case PAGE_ABOUT:
    $page = new PageAboutUs();
    break;

  // Login Page
  case PAGE_LOGIN:

    if(User::getUserRole() == User::ROLE_CUSTOMER){
      header("Location: index.php?page=" . PAGE_ACCOUNT);
      exit;
    }

    $page = new PageLogin();

    // Login action
    if(!empty($_POST) ){

      if(empty($_POST['username'])){
        $page->setErrorMessage('Validation Error. <br>Username cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(empty($_POST['password'])){
        $page->setErrorMessage('Validation Error. <br>Password cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(
        !empty($_POST['username']) &&
        !empty($_POST['password'])
      ){

        $stmt = $pdo->prepare("
            SELECT * FROM Customer 
            WHERE customer_username = :username AND customer_passhash = :password
        ");

        $stmt->execute([
          "username" => $_POST['username'],
          "password" => md5($_POST['username'].'SECRET'.$_POST['password'])
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($user["customer_id"], $user["customer_fullName"])){
          $_SESSION["is_logged_in"] = true;
          $_SESSION["role"] = User::ROLE_CUSTOMER;
          $_SESSION["user"] = [];
          $_SESSION["user"]["customer_fullName"] = $user["customer_fullName"];
          $_SESSION["user"]["customer_id"]       = $user["customer_id"];

          $cart = mergeCartFromSession($pdo);

          header("Location: index.php?page=account");
          exit;
        } else {
          $page->setErrorMessage('Validation Error. <br>Combination of username and password not found.');
        }
      }
    }



    break;

  // Registration Action
  case PAGE_REGISTRATION:

    $page = new PageLogin();

    // Registration action
    if(!empty($_POST) ){

      if(empty($_POST['username'])){
        $page->setErrorMessage('Validation Error. <br>Username cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(empty($_POST['password'])){
        $page->setErrorMessage('Validation Error. <br>Password cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(strlen($_POST['password']) <= 7){
        $page->setErrorMessage('Validation Error. <br>Password must be at least 8 characters.');
        $page->displayPage();
        exit;
      }

      if(empty($_POST['address'])){
        $page->setErrorMessage('Validation Error. <br>Address cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(empty($_POST['fullname'])){
        $page->setErrorMessage('Validation Error. <br>Fullname cannot be empty.');
        $page->displayPage();
        exit;
      }

      if(
        !empty($_POST['username']) &&
        !empty($_POST['password']) &&
        !empty($_POST['address']) &&
        !empty($_POST['fullname'])
      ){

        $stmt = $pdo->prepare("SELECT * FROM Customer WHERE customer_username = :username");
        $stmt->execute([
          "username" => $_POST['username'],
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
          $page->setErrorMessage('Validation Error. <br>User already exist.');
          $page->displayPage();
          exit;
        }


        $stmt_insert = $pdo->prepare("
          INSERT INTO Customer
          (customer_username, customer_passhash, customer_fullName, customer_addr)
          VALUES (:customer_username, :customer_passhash, :customer_fullName, :customer_addr)
        ");

        $res = $stmt_insert->execute([
          ":customer_username" => $_POST['username'],
          ":customer_passhash" => md5($_POST['username'].'SECRET'.$_POST['password']),
          ":customer_fullName" => $_POST['fullname'],
          ":customer_addr"     => $_POST['address'],
        ]);

        if($res){
          $stmt = $pdo->prepare("SELECT * FROM Customer WHERE customer_username = :username AND customer_passhash = :password");

          $stmt->execute([
            "username" => $_POST['username'],
            "password" => md5($_POST['username'].'SECRET'.$_POST['password'])
          ]);
          $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if(isset($user["customer_id"], $user["customer_fullName"])){
            $_SESSION["is_logged_in"] = true;
            $_SESSION["role"] = User::ROLE_CUSTOMER;
            $_SESSION["user"] = [];
            $_SESSION["user"]["customer_fullName"] = $user["customer_fullName"];
            $_SESSION["user"]["customer_id"]       = $user["customer_id"];
          }

          $cart = mergeCartFromSession($pdo);

          header("Location: index.php?page=" . PAGE_ACCOUNT);
          exit;
        } else {
          $page->setErrorMessage('System Error. <br>Cannot create user.');
        }
        break;
      }
    }

    break;

  case PAGE_CART:

    if(!User::hasPermission(User::PERMISSION_VIEW_CART)){
      $page = new PageNotFound();
      $page->displayPage();
      exit;
    }

    $page = new PageCart();

    if(User::getUserRole() == User::ROLE_CUSTOMER){

      // load from db for logged in users
      $stmt = $pdo->prepare("
        SELECT
          oi.oi_artwork,
          oi.oi_orderNum,
          oi.oi_quantity,
          oi.oi_shippingAddr,
          a.artwork_name
        FROM OrderItem oi
        LEFT JOIN ArtWork a ON a.artwork_id = oi.oi_artwork
        WHERE oi.oi_customer = :oi_customer AND oi.oi_orderNum = -1
      ");

      $stmt->execute([
        ":oi_customer" => $_SESSION['user']['customer_id'],
      ]);

      $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else {

      //load from session for guest users
      $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }
    $page->setCartItems($cart_items);

    break;


  case PAGE_WISHLIST:

    if(!User::hasPermission(User::PERMISSION_VIEW_WISHLIST)){
      $page = new PageNotFound();
      $page->displayPage();
      exit;
    }

    $page = new PageWishlist();

    $stmt = $pdo->prepare("
      SELECT
        w.wl_artwork,
        a.artwork_name
      FROM WishlistItem w
      LEFT JOIN ArtWork a ON a.artwork_id = w.wl_artwork
      WHERE w.wl_customer = :wl_customer
    ");

    $stmt->execute([
      ":wl_customer" => $_SESSION['user']['customer_id'],
    ]);

    $wishlist = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $page->setWishlistItems($wishlist);


    break;

  // Order confirmation page
  case PAGE_ORDER_CONFIRMATION:

    if(! $is_logged_in || empty($_SESSION['order_placed']) || (int) $_SESSION['order_placed'] == 0){
        header("Location: index.php?page=cart");
        exit;
    }

    $page = new PageOrderConfirmation();

    $stmt = $pdo->prepare("
      SELECT
        oi.oi_artwork,
        oi.oi_quantity,
        oi.oi_shippingAddr,
        a.artwork_name
      FROM OrderItem oi
      LEFT JOIN ArtWork a ON a.artwork_id = oi.oi_artwork
      WHERE oi.oi_orderNum = :oi_orderNum AND oi.oi_customer = :oi_customer 
    ");

    $stmt->execute([
        ":oi_customer" => $_SESSION['user']['customer_id'],
        ":oi_orderNum" => $_SESSION['order_placed'],
    ]);

    $order = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $page->setOrder($order);
    $page->setOrderNumber($_SESSION['order_placed']);

    unset($_SESSION['order_placed']);

    break;

  // Order history page
  case PAGE_ORDER_HISTORY:

    if(!User::hasPermission(User::PERMISSION_VIEW_ORDER_HISTORY)){
      $page = new PageNotFound();
      $page->displayPage();
      exit;
    }

    $page = new PageOrderHistory();

    $stmt = $pdo->prepare("
      SELECT
        oi.oi_customer,
        oi.oi_orderNum,    
        oi.oi_quantity,
        oi.oi_artwork,
        oi.oi_shippingAddr,
        a.artwork_name
      FROM OrderItem oi
      LEFT JOIN ArtWork a ON a.artwork_id = oi.oi_artwork
      WHERE oi.oi_customer = :oi_customer AND oi.oi_orderNum > -1
      ORDER BY oi.oi_orderNum DESC
    ");

    $stmt->execute([
        ":oi_customer" => $_SESSION['user']['customer_id'],
    ]);

    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $prepared_orders = [];
    foreach ($orders as $k => $cart_item){

      if(!isset($prepared_orders[$cart_item['oi_orderNum']])){
        $prepared_orders[$cart_item['oi_orderNum']] = [];
      }
      $prepared_orders[$cart_item['oi_orderNum']][$cart_item['oi_artwork']] = $cart_item;
    }

    $page->setOrders($prepared_orders);

    break;


  // Logout Action
  case PAGE_LOGOUT:
    User::clearSession();
    header("Location: index.php");
    exit;
    break;

  // Homepage
  default:
    $page = new PageHome();
    break;
}

$page->displayPage();



/**
* Merge Cart from Session to Database
*/
function mergeCartFromSession($pdo){

  if(!isset($_SESSION['cart'], $_SESSION['is_logged_in'], $_SESSION['user']['customer_id'])){
      return false;
  }

  if(!is_array($_SESSION['cart']) || empty($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    return false;
  }

  // load from db for logged in users
  $stmt = $pdo->prepare("
    SELECT
      oi.oi_artwork,
      oi.oi_orderNum,
      oi.oi_quantity,
      oi.oi_shippingAddr,
      a.artwork_name
    FROM OrderItem oi
    LEFT JOIN ArtWork a ON a.artwork_id = oi.oi_artwork
    WHERE oi.oi_customer = :oi_customer AND oi.oi_orderNum = -1
  ");

  $stmt->execute([
    ":oi_customer" => $_SESSION['user']['customer_id'],
  ]);

  $db_cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db_items_by_a_id = [];
  if(is_array($db_cart_items) && count($db_cart_items) > 0 ){
    foreach ($db_cart_items as $key => $row) {
      $db_items_by_a_id[$row["oi_artwork"]] = $row;
    }
  }

  foreach ($_SESSION['cart'] as $key => $sessOrderItem) {

    $artwork_id = $sessOrderItem["oi_artwork"];

    if(isset($db_items_by_a_id[$artwork_id])){

      // update
      if($db_items_by_a_id[$artwork_id]["oi_quantity"] != $sessOrderItem["oi_quantity"]){

        $stmt = $pdo->prepare("
          UPDATE OrderItem oi
            SET oi.oi_quantity = :oi_quantity
          WHERE oi.oi_customer = :oi_customer AND oi.oi_orderNum = :oi_orderNum AND oi.oi_artwork = :oi_artwork
        ");

        $res = $stmt->execute([
          ":oi_customer" => $_SESSION['user']['customer_id'],
          ":oi_quantity" => $db_items_by_a_id[$artwork_id]["oi_quantity"] + $sessOrderItem["oi_quantity"],
          ":oi_orderNum" => -1,
          ":oi_artwork" => $sessOrderItem["oi_artwork"]
        ]);

      }

    } else {

      // insert
      $stmt_insert = $pdo->prepare("
        INSERT INTO OrderItem
        (
          oi_orderNum,
          oi_customer,
          oi_artwork,
          oi_quantity,
          oi_shippingAddr
        )
        VALUES (
          :oi_orderNum,
          :oi_customer,
          :oi_artwork,
          :oi_quantity,
          :oi_shippingAddr
        )
      ");

      $res = $stmt_insert->execute([
          ":oi_orderNum" => -1,
          ":oi_customer" => $_SESSION['user']['customer_id'],
          ":oi_artwork"  => $artwork_id,
          ":oi_quantity" => $sessOrderItem["oi_quantity"],
          ":oi_shippingAddr" => $sessOrderItem["oi_shippingAddr"],
      ]);
    }

  }

  $_SESSION['cart'] = [];


  return true;

}

?>
