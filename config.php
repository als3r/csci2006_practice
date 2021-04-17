<?php

// Database Config
define("DB_HOSTNAME", "localhost");
define("DB_USERNAME", "root"); // "artShopCS");
define("DB_PASSWORD", "root"); // "simplePassword");
define("DB_DATABASE", "csci2006_artShop");

// Pages
define("PAGE_HOME",               "home");
define("PAGE_ARTIST",             "artist");
define("PAGE_ARTWORK",            "artwork");
define("PAGE_ABOUT",              "about-us");
define("PAGE_LOGIN",              "login");
define("PAGE_LOGOUT",             "logout");
define("PAGE_ACCOUNT",            "account");
define("PAGE_ORDER_HISTORY",      "order-history");
define("PAGE_WISHLIST",           "wishlist");
define("PAGE_CART",               "cart");
define("PAGE_ORDER_CONFIRMATION", "order-confirmation");
define("PAGES", [
    PAGE_HOME,
    PAGE_ARTIST,
    PAGE_ARTWORK,
    PAGE_ABOUT,
    PAGE_LOGIN,
    PAGE_LOGOUT,
    PAGE_ACCOUNT,
    PAGE_ORDER_HISTORY,
    PAGE_WISHLIST,
    PAGE_CART,
]);

// Actions
define("ACTION_UPDATE_WISHLIST_ADD_ITEM",    "add-to-wishlist");
define("ACTION_UPDATE_WISHLIST_REMOVE_ITEM", "remove-from-wishlist");
define("ACTION_UPDATE_CART_ADD_ITEM",        "add-to-cart");
define("ACTION_UPDATE_CART_REMOVE_ITEM",     "remove-from-cart");
define("ACTION_UPDATE_CART_QUANTITY",        "update-quantity-cart");
define("ACTION_UPDATE_CART_ADDRESS",         "update-address-cart'");
define("ACTION_PLACE_ORDER",                 "place-order");
define("ACTIONS", [
    ACTION_UPDATE_WISHLIST_ADD_ITEM,
    ACTION_UPDATE_WISHLIST_REMOVE_ITEM,
    ACTION_UPDATE_CART_ADD_ITEM,
    ACTION_UPDATE_CART_REMOVE_ITEM,
    ACTION_UPDATE_CART_QUANTITY,
    ACTION_UPDATE_CART_ADDRESS,
    ACTION_PLACE_ORDER,
]);


// load classes
require_once 'class.user.php';
require_once 'helpers/util.php';
require_once 'helpers/Validation.php';

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
require_once 'pages/PageNotFound.php';
require_once 'pages/PageLogin.php';
require_once 'pages/PageCart.php';
require_once 'pages/PageWishlist.php';
require_once 'pages/PageOrderConfirmation.php';
require_once 'pages/PageOrderHistory.php';