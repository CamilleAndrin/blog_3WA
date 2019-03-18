<?php
include('../config/config.php');
include('utilities/utilities.php');
$vue = 'editArticle.phtml';


try{
    $dbh = connexion();

    $sth = $dbh->prepare("SELECT * FROM `b_categorie`");
            $sth->execute();
            $categories = $sth->fetchAll(PDO::FETCH_ASSOC);

    if(array_key_exists('id',$_GET))
        {
            $id = $_GET['id'];
            $dbh = connexion();
            $sth = $dbh->prepare('SELECT * FROM b_article WHERE a_id = :id');
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            
            $article = $sth->fetch(PDO::FETCH_ASSOC);
            
            if($article)
            {
                $title = $article['a_title'];
                $date = $article['a_date_published'];
                $content = $article['a_content'];
                $categorie = $article['a_categorie'];
                $picture = $article['a_picture'];
            }
        }    

    //On regarde si il y a au moins un nom pour la tâche lors de l'ajout. Si c'est le cas on active le push.
    if(array_key_exists('title', $_POST)){
        var_dump($_POST);
        $errorForms = NULL;
        $id = $_POST['id'];
        $title = !empty($_POST['title']) ? $_POST['title'] : NULL;
        $content = !empty($_POST['article']) ? $_POST['article'] : NULL;
        $categorie = !empty($_POST['categorie']) ? $_POST['categorie'] : NULL;
        $date = !empty($_POST['date']) ? $_POST['date'] : NULL;
        // $time = !empty($_POST['time']) ? $_POST['time'] : NULL;
        if($title == NULL){
            $errorForms[] = 'Un article sans titre ? Vraiment !?!? !';
        }if($categorie == NULL){
            $errorForms[] = 'Choisi une catégorie banane !';
        }
        // }if($date == NULL){
        //     $errorForms[] = 'Et la date de publication c\'est pour les chiens ?  !';
        // }    
        // if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        //     $tmp_name = $_FILES["file"]["tmp_name"];
        //     $picture = uniqid().'-'.basename($_FILES["file"]["name"]);
        //     move_uploaded_file($tmp_name, UPLOADS_DIR.$picture);
        //}        

        /* Si j'ai pas d'erreur j'insert dans la bdd */
        if($errorForms == ''){ 

            $sql = $dbh->prepare("UPDATE b_article SET `a_title`= :title, `a_content` = :content, `a_categorie` = :categorie, `a_date_published` = :dateP WHERE a_id=:id");
            $sql->bindValue(':id', $id, PDO::PARAM_INT);
            $sql->bindValue(':title', $title, PDO::PARAM_STR);
            $sql->bindValue(':content', $content, PDO::PARAM_STR);
            $sql->bindValue(':categorie', $categorie, PDO::PARAM_INT);
            $sql->bindValue(':dateP', $date, PDO::PARAM_STR);
            // $sql->bindValue(':picture',$picture,PDO::PARAM_STR);
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