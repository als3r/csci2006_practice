<?php
require_once 'config.php';
require_once 'helpers/util.php';

require_once 'models/Artist.php';
require_once 'models/Artwork.php';
require_once 'pages/PageHome.php';
require_once 'pages/PageAboutUs.php';
require_once 'pages/PageAccount.php';
require_once 'pages/PageArtwork.php';
require_once 'pages/PageArtworks.php';
require_once 'pages/PageArtist.php';
require_once 'pages/PageArtists.php';
require_once 'pages/PageError.php';
require_once 'pages/PageLogin.php';

session_start();
$pdo = connect_to_database();
$is_logged_in = Page::isLoggedIn();

switch ($_GET['action']) {

  case 'add-to-wishlist':


    if(! $is_logged_in || !isset($_GET['artwork_id']) || (int) $_GET['artwork_id'] == 0){
      // only logged in users are allowed
      header("Location: index.php");
      exit;
    }

    // save to db if user is logged in

    $stmt_insert = $pdo->prepare("
      INSERT INTO WishlistItem
      (wl_customer, wl_artwork)
      VALUES (:wl_customer, :wl_artwork)
      ON DUPLICATE KEY UPDATE wl_customer = wl_customer
    ");

    $res = $stmt_insert->execute([
      ":wl_customer" => $_SESSION['user']['customer_id'],
      ":wl_artwork" => $_GET['artwork_id'],
    ]);

    if($res){
      header("Location: index.php?page=wishlist");
    } else {
      header("Location: index.php?page=error");
    }
    exit;

    // echo '<pre>';
    // var_dump($_GET);
    // var_dump($is_logged_in);
    // var_dump($_SESSION);
    // var_dump($res);
    // echo '</pre>';



    break;


  case 'add-to-cart':


    if($is_logged_in){

      // save to db if user is logged in




    } else {

        // save in Session if user is not logged in




    }


    break;

}
