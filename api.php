<?php
require_once 'config.php';
require_once 'helpers/util.php';

require_once 'models/Artist.php';
require_once 'models/Artwork.php';

$pdo = connect_to_database();


if(isset($_GET['artist']) && (int) $_GET['artist'] > 0){
    $id = (int) $_GET['artist'];
    $artist = new Artist($id, $pdo);
    $artist->loadData($id);

    if($artist){
        returnJSON(['success' => true, 'data' => $artist->getArrayOfAttributes()]);
    }
    return ['success' => false, 'data' => []];
}

if(isset($_GET['artwork']) && (int) $_GET['artwork'] > 0){
    $id = (int) $_GET['artwork'];
    $artwork = new Artwork($id, $pdo);
    $artwork->loadData($id);

    $artwork->loadFacets();
    $artwork->loadSubjects();
    $artwork->loadGenres();
    $artwork->loadLocation();
    $artwork->loadArtist();

    $data = $artwork->getArrayOfAttributes();

    $data['facets']   = $artwork->getFacets();
    $data['subjects'] = $artwork->getSubjects();
    $data['genres']   = $artwork->getGenres();
    $data['location'] = $artwork->getLocation();
    $data['artist']   = ($artwork->getArtist())->getArrayOfAttributes();

    if($artwork){
        returnJSON(['success' => true, 'data' => $data]);
    }
    return ['success' => false, 'data' => []];
}

function returnJSON($arr = []){
    header("Content-Type: application/json ");
    echo json_encode($arr);
    exit;
}