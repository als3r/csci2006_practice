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

    if(!isset($_GET['artwork_id']) || (int) $_GET['artwork_id'] == 0){
      // artwork must be provided
      header("Location: index.php");
      exit;
    }


    if(! $is_logged_in){
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


    if(!isset($_GET['artwork_id']) || (int) $_GET['artwork_id'] == 0){
      // artwork must be provided
      header("Location: index.php");
      exit;
    }

    $artwork_id = (int) $_GET['artwork_id'];

    if($is_logged_in){

      // save to db if user is logged in
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
          -1,
          :oi_customer,
          :oi_artwork,
          1,
          ''
        )
        ON DUPLICATE KEY UPDATE oi_quantity = oi_quantity + 1
      ");

      $res = $stmt_insert->execute([
        ":oi_customer" => $_SESSION['user']['customer_id'],
        ":oi_artwork" => $artwork_id,
      ]);

      if($res){
        header("Location: index.php?page=cart");
      } else {
        header("Location: index.php?page=error");
      }
      exit;



    } else {

        $stmt = $pdo->prepare("
          SELECT * FROM ArtWork
          WHERE artwork_id = :artwork_id
        ");
        $res = $stmt->execute([":artwork_id" => $artwork_id]);

        $artwork = null;
        if($res){
          $artwork = $stmt->fetch(PDO::FETCH_ASSOC);;
        }

        if(empty($artwork) || !isset($artwork["artwork_name"])){
          // cannot load artwork
          header("Location: index.php");
          exit;
        }

        // save in Session if user is not logged in
        if(!isset($_SESSION['cart'])){
          $_SESSION['cart'] = [];
        }

        $row = [];
        $row['oi_orderNum']     = -1;
        $row['oi_customer']     = -1;
        $row['oi_artwork']      = $artwork_id;
        $row['oi_quantity']     = 1;
        $row['oi_shippingAddr'] = '';
        $row['artwork_name']    = $artwork["artwork_name"];


        if(isset($_SESSION['cart'][$artwork_id], $_SESSION['cart'][$artwork_id]['oi_quantity']) ){
          $_SESSION['cart'][$artwork_id]['oi_quantity']++;
        } else {
          $_SESSION['cart'][$artwork_id] = $row;
        }

        header("Location: index.php?page=cart");
        exit;
    }


    break;

}
