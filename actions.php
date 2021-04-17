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
require_once 'pages/PageCart.php';
require_once 'pages/PageWishlist.php';
require_once 'pages/PageOrderConfirmation.php';
require_once 'pages/PageOrderHistory.php';


session_start();
$pdo = connect_to_database();

$action = !empty($_GET['action']) ? $_GET['action'] : '';
$action = !empty($_POST['action']) && $action == '' ? $_POST['action'] : $action;

if(!in_array($action, ACTIONS)){
    $page = new PageNotFound();
    $page->displayPage();
    exit;
}

switch ($action) {

    // Add artwork to wishlist
    case ACTION_UPDATE_WISHLIST_ADD_ITEM:

        if(!User::hasPermission(User::PERMISSION_UPDATE_WISHLIST_ADD_ITEM)){
            $page = new PageNotFound();
            $page->displayPage();
            exit;
        }

        if (!isset($_GET['artwork_id']) || (int)$_GET['artwork_id'] == 0) {
            // artwork must be provided
            header("Location: index.php");
            exit;
        }


        if (!USER::getUserRole() == USER::ROLE_CUSTOMER) {
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

        if ($res) {
            header("Location: index.php?page=wishlist");
        } else {
            header("Location: index.php?page=error");
        }
        exit;
        break;

    // Remove artwork from wishlist
    case ACTION_UPDATE_WISHLIST_REMOVE_ITEM:

        if(!User::hasPermission(User::PERMISSION_UPDATE_WISHLIST_REMOVE_ITEM)){
            $page = new PageNotFound();
            $page->displayPage();
            exit;
        }

        if (!isset($_GET['artwork_id']) || (int)$_GET['artwork_id'] == 0) {
            // artwork must be provided
            header("Location: index.php");
            exit;
        }


        if (!USER::getUserRole() == USER::ROLE_CUSTOMER) {
            // only logged in users are allowed
            header("Location: index.php");
            exit;
        }

        // save to db if user is logged in

        $stmt_delete = $pdo->prepare("
            DELETE FROM WishlistItem
            WHERE wl_customer = :wl_customer AND wl_artwork = :wl_artwork
        ");

        $res = $stmt_delete->execute([
            ":wl_customer" => $_SESSION['user']['customer_id'],
            ":wl_artwork" => $_GET['artwork_id'],
        ]);

        if ($res) {
            header("Location: index.php?page=wishlist");
        } else {
            header("Location: index.php?page=error");
        }
        exit;
        break;

    // Add artwork to cart
    case ACTION_UPDATE_CART_ADD_ITEM:

        if(!User::hasPermission(User::PERMISSION_UPDATE_CART_ADD_ITEM)){
            $page = new PageNotFound();
            $page->displayPage();
            exit;
        }

        if (!isset($_GET['artwork_id']) || (int)$_GET['artwork_id'] == 0) {
            // artwork must be provided
            header("Location: index.php");
            exit;
        }

        $artwork_id = (int)$_GET['artwork_id'];

        if (USER::getUserRole() == USER::ROLE_CUSTOMER) {

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

            if ($res) {
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
            if ($res) {
                $artwork = $stmt->fetch(PDO::FETCH_ASSOC);;
            }

            if (empty($artwork) || !isset($artwork["artwork_name"])) {
                // cannot load artwork
                header("Location: index.php");
                exit;
            }

            // save in Session if user is not logged in
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $row = [];
            $row['oi_orderNum'] = -1;
            $row['oi_customer'] = -1;
            $row['oi_artwork'] = $artwork_id;
            $row['oi_quantity'] = 1;
            $row['oi_shippingAddr'] = '';
            $row['artwork_name'] = $artwork["artwork_name"];


            if (isset($_SESSION['cart'][$artwork_id], $_SESSION['cart'][$artwork_id]['oi_quantity'])) {
                $_SESSION['cart'][$artwork_id]['oi_quantity']++;
            } else {
                $_SESSION['cart'][$artwork_id] = $row;
            }

            header("Location: index.php?page=cart");
            exit;
        }


        break;

    // Remove artwork from cart
    case ACTION_UPDATE_CART_REMOVE_ITEM:

        if(!User::hasPermission(User::PERMISSION_UPDATE_CART_REMOVE_ITEM)){
            $page = new PageNotFound();
            $page->displayPage();
            exit;
        }

        if (!isset($_GET['artwork_id']) || (int)$_GET['artwork_id'] == 0) {
            // artwork must be provided
            header("Location: index.php");
            exit;
        }

        $artwork_id = (int)$_GET['artwork_id'];

        if (USER::getUserRole() == USER::ROLE_CUSTOMER) {

            // save to db if user is logged in
            $stmt_delete = $pdo->prepare("
            DELETE FROM OrderItem
            WHERE
                    oi_orderNum = :oi_orderNum 
                AND oi_customer = :oi_customer
                AND oi_artwork  = :oi_artwork
            ");

            $res = $stmt_delete->execute([
                ":oi_customer" => $_SESSION['user']['customer_id'],
                ":oi_artwork" => $artwork_id,
                ":oi_orderNum" => -1,
            ]);

            if ($res) {
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
            if ($res) {
                $artwork = $stmt->fetch(PDO::FETCH_ASSOC);;
            }

            if (empty($artwork) || !isset($artwork["artwork_name"])) {
                // cannot load artwork
                header("Location: index.php");
                exit;
            }

            // save in Session if user is not logged in
            if (isset($_SESSION['cart'][$artwork_id])) {
                unset($_SESSION['cart'][$artwork_id]);
            }

            header("Location: index.php?page=cart");
            exit;
        }
        break;

    // Update quantity for cart
    case ACTION_UPDATE_CART_QUANTITY:

        if(!User::hasPermission(User::PERMISSION_UPDATE_CART_QUANTITY)){
            $page = new PageNotFound();
            $page->displayPage();
            exit;
        }

        if (!isset($_POST['artwork_id']) || (int) $_POST['artwork_id'] == 0) {
            // artwork must be provided
            header("Location: index.php");
            exit;
        }

        if (!isset($_POST['quantity']) || (int) $_POST['quantity'] == 0) {
            // artwork must be provided
            header("Location: index.php");
            exit;
        }

        if(empty($_POST['quantity'])){
            $page = new PageCart();
            if(USER::getUserRole() == USER::ROLE_CUSTOMER){

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
            $page->setErrorMessage('Validation Error. <br>Quantity cannot be empty.');
            $page->displayPage();
            exit;
        }

        $artwork_id = (int) $_POST['artwork_id'];
        $quantity   = (int) $_POST['quantity'];

        if (USER::getUserRole() == USER::ROLE_CUSTOMER) {

            // save to db if user is logged in
            $stmt_update = $pdo->prepare("
            UPDATE OrderItem
            SET oi_quantity = :oi_quantity
            WHERE 
                oi_orderNum     = :oi_orderNum
                AND oi_customer = :oi_customer
                AND oi_artwork  = :oi_artwork
            ");

            $res = $stmt_update->execute([
                ":oi_customer" => $_SESSION['user']['customer_id'],
                ":oi_artwork"  => $artwork_id,
                ":oi_quantity" => $quantity,
                ":oi_orderNum" => -1,
            ]);

            if ($res) {
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
            if ($res) {
                $artwork = $stmt->fetch(PDO::FETCH_ASSOC);;
            }

            if (empty($artwork) || !isset($artwork["artwork_name"])) {
                // cannot load artwork
                header("Location: index.php");
                exit;
            }

            // save in Session if user is not logged in
            if (isset($_SESSION['cart'][$artwork_id]['oi_quantity'])) {
                $_SESSION['cart'][$artwork_id]['oi_quantity'] = (int) $quantity;
            }

            header("Location: index.php?page=cart");
            exit;
        }


        break;

    // Update address for cart
    case ACTION_UPDATE_CART_ADDRESS:

        if(!User::hasPermission(User::PERMISSION_UPDATE_CART_ADDRESS)){
            $page = new PageNotFound();
            $page->displayPage();
            exit;
        }

        if (!isset($_POST['artwork_id']) || (int)$_POST['artwork_id'] == 0) {
            // artwork must be provided
            header("Location: index.php");
            exit;
        }

        if(empty($_POST['address'])){
            $page = new PageCart();
            if(USER::getUserRole() == USER::ROLE_CUSTOMER){

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
            $page->setErrorMessage('Validation Error. <br>Address cannot be empty.');
            $page->displayPage();
            exit;
        }

        $artwork_id = (int) $_POST['artwork_id'];
        $address    = $_POST['address'];

        if (USER::getUserRole() == USER::ROLE_CUSTOMER) {

            // save to db if user is logged in
            $stmt_update = $pdo->prepare("
            UPDATE OrderItem
            SET oi_shippingAddr = :oi_shippingAddr
            WHERE 
                oi_orderNum     = :oi_orderNum
                AND oi_customer = :oi_customer
                AND oi_artwork  = :oi_artwork
            ");

            $res = $stmt_update->execute([
                ":oi_customer" => $_SESSION['user']['customer_id'],
                ":oi_artwork"  => $artwork_id,
                ":oi_shippingAddr" => $address,
                ":oi_orderNum" => -1,
            ]);

            if ($res) {
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
            if ($res) {
                $artwork = $stmt->fetch(PDO::FETCH_ASSOC);;
            }

            if (empty($artwork) || !isset($artwork["artwork_name"])) {
                // cannot load artwork
                header("Location: index.php");
                exit;
            }

            // save in Session if user is not logged in
            if (isset($_SESSION['cart'][$artwork_id]['oi_shippingAddr'])) {
                $_SESSION['cart'][$artwork_id]['oi_shippingAddr'] = $address;
            }

            header("Location: index.php?page=cart");
            exit;
        }


        break;

    // Place Order
    case ACTION_PLACE_ORDER:

        if(!User::hasPermission(User::PERMISSION_PLACE_ORDER)){
            $page = new PageNotFound();
            $page->displayPage();
            exit;
        }

        if (!USER::getUserRole() == USER::ROLE_CUSTOMER) {
            // only logged in users are allowed
            header("Location: index.php");
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT
                (MAX(oi_orderNum) + 1) as nextOrderNumber 
            FROM OrderItem 
            WHERE oi_orderNum > -1
        ");
        $res = $stmt->execute();
        if(!$res){
            // error
            header("Location: index.php?page=cart");
            exit;
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nextOrder = (int) $result['nextOrderNumber'];
        $nextOrder = $nextOrder == 0 ? 1 : $nextOrder;

        // mark order as completed
        $stmt = $pdo->prepare("
            UPDATE OrderItem oi
            SET oi.oi_orderNum = :orderNum
            WHERE 
                    oi.oi_orderNum = -1
                AND oi.oi_customer = :oi_customer
        ");
        $res = $stmt->execute([
            ":orderNum" => $nextOrder,
            ":oi_customer" => $_SESSION["user"]["customer_id"]
        ]);

        if($res){
            // Transfer to Confirmation page
            $_SESSION["order_placed"] = $nextOrder;
            header("Location: index.php?page=order-confirmation");
            exit;
        } else {
            // error
            header("Location: index.php?page=cart");
            exit;
        }
        break;
}
