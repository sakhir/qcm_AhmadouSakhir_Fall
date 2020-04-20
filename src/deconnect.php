<?php 

// on declare la session

session_start();

// On écrase le tableau de session

$_SESSION = array();

// Puis on la détruit la session donc le numéro unique de session 

//session_destroy();

unset($_SESSION);

header("Cache-Control: no-store, no-cache, must-revalidate");

header("Location:authentification.php");

exit;
 ?>