<?php
include('../config/config.php');
include('utilities/utilities.php');

$vue = 'loginUser.phtml';
$email = '';
$password = '';
$message = '';

try{
    $dbh = connexion();
    if(array_key_exists('email', $_POST)){
        $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
        $password = !empty($_POST['password']) ? $_POST['password'] : NULL;
        if($email == NULL){
            $errorForms[] = 'Il nous faut une adresse mail pour te retrouver (dans la base de données hein !).';
        }if($password == NULL){
            $errorForms[] = 'Si tu mets pas de mot de passe, tu peux pas te connecter !';
        }

        $sth = $dbh->prepare('
        SELECT *
        FROM b_user
        WHERE u_email = :email
        ');
        $sth->bindValue(':email', $email, PDO::PARAM_STR);
        $sth->execute();
        $userData = $sth->fetch(PDO::FETCH_ASSOC);

        if(password_verify($password, $userData['u_password'])){
            session_start();
            $_SESSION['connected'] = true;
            $_SESSION['login'] = $userData['u_id'];
            $_SESSION['flashbag'] = 'Bravo connexion réussit' ;
            header('location:listArticle.php');
            exit();
            // $message ='Bienvenue ' . $userData['u_firstname']. " " . $userData['u_lastname'];
        } else {
            $message = 'Bien essayé Pedro, mais ce ne sont pas les bonnes données !';
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