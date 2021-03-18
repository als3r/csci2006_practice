<?php
require_once 'Rating.php';

// process new rating
if(
  isset($_POST['user_id'], $_POST['rating_value'], $_POST['rating_type'], $_POST['rating_entity_id'])
){

  $user_id      = (int) $_POST['user_id'];
  $rating_value = (float) $_POST['rating_value'];
  $entity_id    = (int) $_POST['rating_entity_id'];
  $rating_type  = in_array($_POST['rating_type'], Rating::TYPES) ? $_POST['rating_type'] : null;

  if($user_id > 0 && $rating_value > 0 && $entity_id > 0 && ! is_null($rating_type)) {

      $rating = new Rating();
      $rating->setUserId($user_id);
      $rating->setRatingValue($rating_value);
      $rating->setEntityId($entity_id);
      $rating->setRatingType($rating_type);
      $rating_id = $rating->create();

      if($rating_id){
        echo '<h1>Rating Was Saved. ID: ' . $rating_id . '</h1>'; exit;
      } else {
        echo '<h1>Error - Rating Was Not Saved</h1>'; exit;
      }

  } else {
    echo '<h1>Error - Validation Error</h1>'; exit;
  }
} else {
  echo '<h1>Error - Form Is Not Valid</h1>'; exit;
}





?>
