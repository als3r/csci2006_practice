<?php

/**
 * Connect to database
 *
 * @return PDO
 */
function connect_to_database(){
    try {
        // Connection Open
        $connString = "mysql:host=".DB_HOSTNAME.";dbname=" . DB_DATABASE;
        $pdo = new PDO($connString, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}