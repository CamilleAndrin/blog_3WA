<?php
session_start();
include('../config/config.php');
include('utilities/utilities.php');

if(!isset($_SESSION['connected']) !== true){
    $vue = 'addArticle.phtml';
}else{
    $vue = 'erreur.phtml';
    $messageErreur = '<p>Vous devez être connecté pour accéder à cette page</p> <a href="loginUser.php">login</a>';
}

$title = '';
$article = '';
$categorie = '';
$auteur = '';
$date = '';
$time = '';

try{
    $dbh = connexion();

    $sth = $dbh->prepare("SELECT * FROM `b_categorie`");
            $sth->execute();
            $categories = $sth->fetchAll(PDO::FETCH_ASSOC);

    //On regarde si il y a au moins un nom pour la tâche lors de l'ajout. Si c'est le cas on active la fonction push.
    if(array_key_exists('title', $_POST)){
        $errorForms = NULL;
        $title = !empty($_POST['title']) ? $_POST['title'] : NULL;
        $article = !empty($_POST['article']) ? $_POST['article'] : NULL;
        $categorie = !empty($_POST['categorie']) ? $_POST['categorie'] : NULL;
        $auteur = !empty($_POST['author']) ? $_POST['author'] : NULL;
        $date = !empty($_POST['date']) ? $_POST['date'] : NULL;
        $time = !empty($_POST['time']) ? $_POST['time'] : NULL;
        if($title == NULL){
            $errorForms[] = 'Un article sans titre ? Vraiment !?!? !';
        }if($categorie == NULL){
            $errorForms[] = 'Choisi une catégorie banane !';
        }if($auteur == NULL){
            $errorForms[] = 'Faut signer pour gagner ! Il te manque l\'auteur coco !';
        }if($date == NULL){
            $errorForms[] = 'Et la date de publication c\'est pour les chiens ?  !';
        }    
        if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["file"]["tmp_name"];
            $picture = uniqid().'-'.basename($_FILES["file"]["name"]);
            move_uploaded_file($tmp_name, UPLOADS_DIR.$picture);
        }        

        /* Si j'ai pas d'erreur j'insert dans la bdd */
        if($errorForms == ''){
            
            $sql = $dbh->prepare("INSERT INTO `b_article` (`a_id`, `a_title`, `a_date_published`, `a_content`, `a_picture`, `a_categorie`, `a_author`) 
                    VALUES (NULL, :title, :dateP, :article, :picture, :categorie , :auteur)
                    ");
            $sql->bindValue(':title', $title, PDO::PARAM_STR);
            $sql->bindValue(':article', $article, PDO::PARAM_STR);
            $sql->bindValue(':categorie', $categorie, PDO::PARAM_INT);
            $sql->bindValue(':auteur', $auteur, PDO::PARAM_INT);
            $sql->bindValue(':dateP', $date, PDO::PARAM_STR);
            $sql->bindValue(':picture',$picture,PDO::PARAM_STR);
            $sql->execute();
            
            header('location:listArticle.php');
            exit();   
        }
        
    }
}
    
catch(PDOException $e)
{
    $vue = 'erreur.phtml';
    $messageErreur = 'Une erreur de connexion a eu lieu :'.$e->getMessage();
}

include('tpl/layout.phtml')
?>