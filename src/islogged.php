<?php
 session_start();
// si l'utilisateur n'est pas loggué ou s'il ne dois pas avoir accès à ce script
 
if (!isset($_SESSION['user']) || $_SESSION['profil']==='joueur' ) {
    //header("HTTP/1.1 403 Forbidden");  // header "interdit" 
    include 'errorpage.html';
    header("Refresh:7;url=Authentification.php");// redirection vers "login.php" dans 5 
    die();
 
}

?>