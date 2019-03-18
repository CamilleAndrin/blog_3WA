<?php
//Configuration connexion serveur base de données distant (cloud9)
const DB_SGBD = 'mysql';
const DB_SGBD_URL = 'localhost';
const DB_DATABASE = 'camillea_blog';
const DB_CHARSET ='utf8';
const DB_USER = 'camillea';
const DB_PASS = 'OTkzOTM4YWZmZDM2YzI5MWVmZjQ3NzZk3Wa!';

//Configuration connexion serveur base de données local
// const DB_SGBD = 'mysql';
// const DB_SGBD_URL = 'localhost';
// const DB_DATABASE = 'camillea_blog';
// const DB_CHARSET ='utf8';
// const DB_USER = 'root';
// const DB_PASS = '';

/** FILES */
//Répertoire chemin complet vers le blog (pour l'upload)
define('UPLOADS_DIR', realpath(dirname(__FILE__)."/../").'/img/uploads/');

// URL complète vers le répertoire upload (pour l'affichage des images dans l'HTML)
const UPLOADS_URL = 'http://camillea.sites.pixelsass.fr/dev/php/blog/img/uploads/';

?>