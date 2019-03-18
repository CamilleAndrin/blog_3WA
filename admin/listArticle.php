<?php
session_start();
include('../config/config.php');
include('utilities/utilities.php');


if(!isset($_SESSION['connected']) !== true){
    $vue = 'listArticle.phtml';
}else{
    $vue = 'erreur.phtml';
    $messageErreur = '<p>Vous devez être connecté pour accéder à cette page</p> <a href="loginUser.php">login</a>';
}

try{
    $dbh = connexion();

    $sth = $dbh->prepare('
    SELECT * 
    FROM b_article
    ');
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sth = $dbh->prepare("SELECT * FROM `b_categorie`");
    $sth->execute();
    $resultCategories = $sth->fetchAll(PDO::FETCH_ASSOC);
    $categories = array_column($resultCategories, 'c_title', 'c_id');
}
catch(PDOExecption $e){
    $vue = 'erreur.phtml';
    $messageErreur = 'Une erreur de connexion a eu lieu :'.$e->getMessage();
}

include('tpl/layout.phtml');
?>