<?php
session_start();
include('../config/config.php');
include('utilities/utilities.php');

if(!isset($_SESSION['connected']) !== true){
    $vue = 'addUser.phtml';
}else{
    $vue = 'erreur.phtml';
    $messageErreur = '<p>Vous devez être connecté pour accéder à cette page</p> <a href="loginUser.php">login</a>';
}


$nom = '';
$prenom = '';
$email = '';
$password = '';
$role = '';

try{
    $dbh = connexion();

    //On regarde si il y a au moins un nom pour la tâche lors de l'ajout. Si c'est le cas on active la fonction push.
    if(array_key_exists('nom', $_POST)){
        $errorForms = NULL;
        $nom = !empty($_POST['nom']) ? $_POST['nom'] : NULL;
        $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : NULL;
        $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
        $password = !empty($_POST['password']) ? $_POST['password'] : NULL;
        $role = !empty($_POST['role']) ? $_POST['role'] : NULL;
       
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        if($nom == NULL){
            $errorForms[] = 'Quel est ton nom étranger ?!';
        }if($prenom == NULL){
            $errorForms[] = 'Tu vas pas me faire croire que ton prénom c\'est juste !';
        }if($email == NULL){
            $errorForms[] = 'Il nous faut une adresse mail pour pouvoir te spammer de mails poubelles.';
        }if($password == NULL){
            $errorForms[] = 'Si tu mets pas de mot de passe je peux pas tester mon code .... Pleeeaaase !';
        }if($role == NULL){
            $errorForms[] = 'Quel est ton rôle dans cette affaire ?';
        }

        /* Si j'ai pas d'erreur j'insert dans la bdd */
        if($errorForms == ''){
            
            $sql = $dbh->prepare("INSERT INTO `b_user` (`u_id`, `u_firstname`, `u_lastname`, `u_email`, `u_password`, `u_role`)
                   VALUES (NULL, :prenom, :nom, :email, :pass, :rol)
                   ");
            $sql->bindValue(':nom', $nom, PDO::PARAM_STR);
            $sql->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $sql->bindValue(':email', $email, PDO::PARAM_STR);
            $sql->bindValue(':pass', $passwordHashed, PDO::PARAM_STR);
            $sql->bindValue(':rol', $role, PDO::PARAM_STR);
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
