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

<!DOCTYPE html>
<html>
<head>
	<title> Liste question</title>
	<link rel="stylesheet" type="text/css" href="../css/listequestion.css">
</head>
<body>
<div id="container">

  <header>
           <nav>  
             <img id="logosa" src="../Images/logo-QuizzSA.png">
             <span> Le Plaisir de jouer </span> 
          </nav>
           
  </header>  

 <div class="inset">
  <div class="login-head">
    <h1>CREER ET PARAMETRER VOS QUIZZ </h1>
    
      <a href="deconnect.php"><input  class="deconnect" type="button" name="deconnect" value="Deconnexion"></a>
         
  </div>
  
<div id="milieu">
     <div class="gauche">
      <div class="degrade"> <img class="profiler" style=" height: 15%;" src="../images/avatar/<?php if (isset($_SESSION['avatar'])) {echo $_SESSION['avatar'];} ?>">
    <span id="pnom"><?php if (isset($_SESSION['nom']) and isset($_SESSION['prenom']) )
    {
    echo $_SESSION['prenom'].' '.$_SESSION['nom'] ; }?></span> </div>
      <div class="menu">
         <div id="sidebar">

                <ul>
                  
                    <li class="active">
                        <a href="listequestions.php">Liste Questions<img src="../Images/Icônes/ic-liste.png"> </a>
                     </li>
                     <li >   
                        <a href="creationcompte.php">Creer Admin<img src="../Images/Icônes/ic-ajout-active.png"> </a>
                        
                    </li>
                    <li >
                        <a href="listejoueurs.php">Liste Joueurs <img src="../Images/Icônes/ic-liste.png"> </a>
                    </li>
                    <li>
                        <a href="creerquestion.php">Creer Questions<img src="../Images/Icônes/ic-ajout.png"> </a>
                    </li>
                </ul>

                
            </div>
      </div>
  </div>
  <div class="droite">
     <div class="droite-content">
      <div class="haut">
       <label style="font-size: 20px;">Nbre de question/jeu </label>
       <input type="text" name="nbrq" style="width: 10%;height: 15%;">
       <input type="button" name="ok" value="OK" style="background-color:#5e90af;font-size: 20px;color: white; ">
      </div>
       <div id="bleu">
         <!-- debut des questions -->


        <!--  fin des questions  -->
       </div>
       <button style="width: 30%;background-color:#3addd6;margin-left: 57%;margin-top:2%;font-size: 25px;color: white; ">suivant</button>
     </div>
  </div>
         

        
  </div>

  </div>

</div>



<?php  
?>
</body>
</html>




<!--menu side bar-->


    





