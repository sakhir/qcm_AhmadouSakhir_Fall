<?php
 session_start();
// si l'utilisateur n'est pas loggué ou s'il ne dois pas avoir accès à ce script
 
if (!isset($_SESSION['user']) || $_SESSION['profil']==='admin' ) {
    //header("HTTP/1.1 403 Forbidden");  // header "interdit" 
    include 'errorpage.html';
    header("Refresh:7;url=Authentification.php");// redirection vers "login.php" dans 5 
    die();
 
}

?>

<!DOCTYPE html>
<html>
<head>
	<title> Espace Joueur</title>
	<link rel="stylesheet" type="text/css" href="../css/Espjoueur.css?v=1">

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
    <div class="degrade"><img class="profiler" src="../images/avatar/<?php if (isset($_SESSION['avatar'])) {echo $_SESSION['avatar'];} ?>">
    <span id="pnom"><?php if (isset($_SESSION['nom']) and isset($_SESSION['prenom']) )
    {
    echo $_SESSION['prenom'].' '.$_SESSION['nom'] ; }?></span> </div>
    <h1> BIENVENUE SUR LA PLATEFORME DE JEU DE QUIZZ <br>JOUER ET TESTER VOTRE NIVEAU DE CULTURE GENERALE </h1>
    
     <a  href="deconnect.php"> <input  class="deconnect" type="button" name="deconnect" value="Deconnexion"> </a>
         
  </div>
  
  <div id="milieu">
     
    <div class="droite">
        <div class="droite-content">
      
           <div id="bleu">
               <form method="post" name="formquestion" id="myform">
                     
                        
                      <div  style="width: 90%; height: 150px;margin-left: 5%;margin-top: 2%; border-radius: 1px;background-color:#F4F4F4;font-size: 27px;text-align:center;">
                       
                     <div id='quiz'></div>  
                      
                      </div> <!-- fin div question  --><br>
              
                   


                  <div class="button" id='next'><button  style="background-color:#51BFD0; width: 20%;height: 45px;margin-top: 21%;margin-left:38%;position: absolute;"><a  href='#' style="font-size :20px;color:white;text-decoration:none;">Suivant</a></button></div>


                <div class="button" id='prev'><button style="background-color:#828180; width: 20%;height: 45px;margin-top: 21%;margin-left:2%;position: absolute;"><a href='#' style="font-size :20px;color:white;text-decoration:none;">Precedent</a></button></div>


                <div class="button" id='start'><button style="background-color:#042425; width: 17%;height: 45px;margin-top: 25%;margin-left:20%;position: absolute;"> <a href='#' style="font-size :20px;color:white;text-decoration:none;">VALIDER</a></button></div>  
             
              </form>

           </div> <!-- fin div bleu -->
        </div>
         <div class="gauche">
    
             <div class = "tabinator">
                <input type = "radio" id = "tab1" name = "tabs" checked>
                <label for = "tab1" class="tab1">Top scores</label>
                <input type = "radio" id = "tab2" name = "tabs">
                <label for = "tab2" class="tab2">Mon meilleur score</label>
                <div id = "content1">
                  <?php 
    // fonction de tri bulle 

function triBulleDecroissant($tab) {
    
   $tampon = 0;
   $permut;
 
    do {
      // hypothèse : le tableau est trié
      $permut = false;
      for ( $i = 0; $i < count($tab) - 1; $i++) {
        // Teste si 2 éléments successifs sont dans le bon ordre ou non
        if (  intval($tab[$i]['score']) < intval($tab[$i+1]['score']) ) {

          // s'ils ne le sont pas, on échange leurs positions
          $tampon = $tab[$i];
          $tab[$i] = $tab[$i + 1];
          $tab[$i+1] =$tampon;
          $permut = true;
        }
      }
    } while ($permut);
    return $tab;
  }
// fin fonction de tri 

                $inp = file_get_contents('../json/gamers.json');
                $tab= json_decode($inp,true);
                $tab=triBulleDecroissant($tab);
                $NbrCol = 3;
$NbrLigne=5;
echo '<table border="0" width="285">';
$couleur = array('#50DAC2','#6AD7D1','#F8B106','#EF7E05','#EEEEEE');

for ($i=0; $i< $NbrLigne; $i++) {
  if (!empty($tab[$i]['prenom']) and isset($tab[$i]['prenom'])) {

   echo '<tr>';
           
              echo '<td style="font-size:18px;font-weight:bold;">';

                echo $tab[$i]['prenom'];                  
                echo '</td>';
                echo '<td style="font-size:18px;font-weight:bold;">';
                echo $tab[$i]['nom'];
                echo "</td>";
                echo '<td style="font-size:18px;font-weight:bold;">';
                echo $tab[$i]['score'];
                echo " pts";
                echo '<hr style="background-color:'.$couleur[$i].';height:4px;border-radius:25%;width:90%;">';
                echo "</td>";
 
            
   echo '</tr>';
  }  

}

echo '</table>';
?>

                </div>
                <div id = "content2">
                  <p style="font-size: 18px;font-weight: bold;"><?php if (isset($_SESSION['nom']) and isset($_SESSION['prenom']) )
    {
     echo $_SESSION['prenom'].' '.$_SESSION['nom'].'  3000 pts' ; }?>
                  </p>
                </div>
  
              </div>
      
          </div>
      
        </div>
   
     </div>

  </div>

</div> <!-- fin div container -->



<?php  




?>



 <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>

 <script type='text/javascript' src='../js/js1quiz.js'></script>


</body>
</html>




<!--menu side bar-->


 




