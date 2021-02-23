<?php
require_once 'Artist.php';
require_once 'Artwork.php';
require_once 'PageHome.php';
require_once 'PageAboutUs.php';
require_once 'PageAccount.php';
require_once 'PageArtwork.php';
require_once 'PageArtist.php';
require_once 'PageError.php';

switch ($_GET['page']) {

  // Artwork page
  case 'artist':

    $page = new PageArtist();

    // create 3 instances of artists
    $artists = [];
    $artists[1] = new Artist(1);
    $artists[2] = new Artist(2);
    $artists[3] = new Artist(3);

    // "test" update/delete/create and save functions
    // "results" will be in the log
    $artists[1]->setFirstName("Test First Name 123");
    $artists[1]->setYearBirth(1100);
    $artists[1]->setYearDeath(1200);
    $artists[1]->save();

    $artists[1]->deleteOneById(1);

    $new_artist = new Artist();
    $new_artist->setFirstName("Test Name");
    $new_artist->setMiddleName("Test");
    $new_artist->setLastName("Test Last Name");
    $new_artist->setNationality("Test Nationality");
    $new_artist->setYearBirth(1000);
    $new_artist->setYearDeath(2000);
    $new_artist->setNationality("Test Nationality");
    $new_artist->setDescription("Test Description");
    $new_artist->setGenres("Test Genres");
    $new_artist->setImageTitle("Test Image Title");
    $new_artist->setImage("test.jpg");
    $new_artist->create();

    // end tests, reload artwork 1
    $artists[1] = new Artist(1);

    // if id param is provided use it, otherwise use random of 1-3
    $id = empty($_GET['id']) || (int) $_GET['id'] == 0 ? rand(1,3) : (int) $_GET['id'];

    // set artist for the page
    if(isset($artists[$id])){
      $page->setArtist($artists[$id]);
    } else {
      $page = new PageError();
      $page->setErrorMessage("Error. There are only 3 artists currently. ID: " . (int) $id . " is out of range of 3.");
    }


    break;

  // Artist Page
  case 'artwork':
    $page = new PageArtwork();

    // create 3 instances of artworks
    $artworks = [];
    $artworks[1] = new Artwork(1);
    $artworks[2] = new Artwork(2);
    $artworks[3] = new Artwork(3);

    // "test" update/delete/create and save functions
    // "results" will be in the log
    $artworks[1]->setTitle("Test Title");
    $artworks[1]->setHeight(300);
    $artworks[1]->save();

    $artworks[1]->deleteOneById(1);

    $new_artwork = new Artwork();
    $new_artwork->setTitle("Test Title");
    $new_artwork->setArtistId(1);
    $new_artwork->setDescription("Test Description");
    $new_artwork->setSubjects("Test Subjects");
    $new_artwork->setGenres("Test Genres");
    $new_artwork->setMedium("Test Medium");
    $new_artwork->setSimilarArtwork("Test Similar Artwork");
    $new_artwork->setHome("Test Home");
    $new_artwork->setWidth(100);
    $new_artwork->setHeight(200);
    $new_artwork->setPrice(777);
    $new_artwork->setImage("test.jpg");
    $new_artwork->create();

    // end tests, reload artwork 1
    $artworks[1] = new Artwork(1);


    // if id param is provided use it, otherwise use random of 1-3
    $id = empty($_GET['id']) || (int) $_GET['id'] == 0 ? rand(1,3) : (int) $_GET['id'];

    // set artwork for the page
    if(isset($artworks[$id])){
      $page->setArtwork($artworks[$id]);
    } else {
      $page = new PageError();
      $page->setErrorMessage("Error. There are only 3 artworks currently. ID: " . (int) $id . " is out of range of 3.");
    }

    break;

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
