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
	<title> Creation de question</title>
	<link rel="stylesheet" type="text/css" href="../css/creerquestion.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

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
                  
                    <li>
                        <a href="listequestions.php">Liste Questions<img src="../Images/Icônes/ic-liste.png"> </a>
                     </li>
                     <li >   
                        <a href="creationcompte.php">Creer Admin<img src="../Images/Icônes/ic-ajout-active.png"> </a>
                        
                    </li>
                    <li >
                        <a href="listejoueurs.php">Liste Joueurs <img src="../Images/Icônes/ic-liste.png"> </a>
                    </li>
                    <li class="active">
                        <a href="creerquestion.php">Creer Questions<img src="../Images/Icônes/ic-ajout.png"> </a>
                    </li>
                </ul>

                
            </div>
      </div>
  </div>

  <?php 
      $selected='selected="selected"';
      (isset($_POST['liste'])) ? $liste=$_POST['liste'] : $liste="";
     ?>

  <div class="droite">
     <div class="droite-content">
       <h2>PARAMETRER VOTRE QUESTION   </h2> 
       <div id="bleu">
         <form method="post" name="formulaireDynamique">
                  <label for="questions" style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Questions  </label>
                  <input type="textarea" name="question" value="<?php if (isset($_POST['liste'])) echo htmlentities($_POST['question']) ?>" style="width: 70%; height: 90px;margin-left: 5%;margin-top: 5%; border-radius: 5px;background-color:#F4F4F4; "> <br><br>

                   <label for="score" style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Nbre de Points</label>
                  <input type="number" name="score" value="<?php if (isset($_POST['liste'])) echo htmlentities($_POST['score']) ?>" min="0" style="width: 10%; height:30px;margin-left: 2%;margin-top: 5%;background-color:#F4F4F4;border:1px;border-style:solid;border-color:  #51BFD0 ;" > <br><br>

                  <label for="score" style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Type de reponse  </label>
                     <select name="liste" onchange="submit();" style="width: 60%; height:35px;margin-left: 2%%;margin-top: 5%;background-color:#F4F4F4;">
                      <option>Donnez le type de reponse </option>
                      <option  <?php if($liste=="Choix Multiple") echo $selected; ?> > Choix Multiple</option>
                      <option <?php if ($liste=="Choix simple") echo $selected; ?>> Choix simple</option>
                      <option <?php if ($liste=="Choix texte") echo $selected; ?>> Choix texte</option>
                     </select>  
                    


  <?php 
          if ($liste=="Choix texte") 
              { 
  ?><br><br>
  <label for="reponsetexte" style="font-size: 21px;font-weight: bold;margin-left: 2%;" >Reponse</label>
  <input type="text" name="texte" style="width:60%; height:30px;background-color:#F4F4F4; margin-left:30%;
  " > <br>
  <?php 
  } 
  
   if ($liste=="Choix simple") 
  {
    ?> 
       <img src="../Images/Icônes/ic-ajout-réponse.png" style="position: absolute;margin-top: 4.3%;margin-left:1%;" onclick="ajoutS(this)">
 <?php 
  }


if ($liste=="Choix Multiple") 
  {
    ?>
       <img src="../Images/Icônes/ic-ajout-réponse.png" style="position: absolute;margin-top: 4.3%;margin-left:1%;" onclick="ajoutM(this)">
 <?php 
  }


  ?>

                      <input type="submit" name="valider" value="Enregistrer" style="color: white; background-color: #51BFD0;width: 20%; height: 40px; border-radius: 5px;font-size: 15px;margin-top:10%;margin-left:75%;position: relative;">

          </form>
       </div>
     </div>
  </div>
         

        
  </div>

  </div>

</div>



<?php  

// le traitement s il clique sur le bouton enregistgrer :
// fin du isset 


?>
</body>
</html>




<!--menu side bar-->


    





