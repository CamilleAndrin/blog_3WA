<?php
 $connected = false;

function connexion(){
    $dbh = new PDO(DB_SGBD.':host='.DB_SGBD_URL.';dbname='.DB_DATABASE.';charset='.DB_CHARSET, DB_USER, DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>