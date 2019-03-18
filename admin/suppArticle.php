<?php
include('../config/config.php');
include('utilities/utilities.php');

try
{
    if(array_key_exists('id',$_GET))
    {
        $id = $_GET['id'];
        $dbh = connexion();
        $sth = $dbh->prepare('SELECT * FROM '.'b_'.'article WHERE a_id = :id');
        $sth->execute(['id'=>$id]);
        $article = $sth->fetch(PDO::FETCH_ASSOC);
        
        if($article)
        {
            $file = UPLOADS_DIR.'articles/'.$article['a_picture'];
            if(file_exists($file) && !is_dir($file))
            unlink($file);

            $supp = $dbh->prepare('DELETE FROM '.'b_'.'article WHERE a_id = :id');
            $supp->execute(['id'=>$id]);

            //addFlashBag('L\'article a bien été supprimé');
            header('Location:listArticle.php');
            exit();
        }
    }
}
catch(PDOExecption $e){
    $vue = 'erreur.phtml';
    $messageErreur = 'Une erreur de connexion a eu lieu :'.$e->getMessage();
}

include('tpl/layout.phtml');

?>