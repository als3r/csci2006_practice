<?php
require_once 'config.php';
require_once 'util.php';

require_once 'Artist.php';
require_once 'Artwork.php';
require_once 'PageHome.php';
require_once 'PageAboutUs.php';
require_once 'PageAccount.php';
require_once 'PageArtwork.php';
require_once 'PageArtworks.php';
require_once 'PageArtist.php';
require_once 'PageArtists.php';
require_once 'PageError.php';

$pdo = connect_to_database();

switch ($_GET['page']) {

  // Artwork page
  case 'artist':

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
  case 'artwork':

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
  case 'account':
    $page = new PageAccount();
    break;

  // About Us Page
  case 'about-us':
    $page = new PageAboutUs();
    break;

  // Homepage
  default:
    $page = new PageHome();
    break;
}

$page->displayPage();
?>
