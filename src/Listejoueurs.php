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
	<title> ListeJoueurs</title>
	<link rel="stylesheet" type="text/css" href="../css/listejoueurs.css">

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
                    <li class="active">
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
       <strong style="top:5%;margin-left: 12%;font-size: 25px;"> LISTE DES JOUEURS PAR SCORE  </strong> 
       <div id="bleu">
           <!-- debut liste des joueurs  -->
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



                
                //rsort($tab);
                
                              

$page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
$total = count($tab);  
$limit = 3; //par page    
$totalPages = ceil( $total/ $limit ); 
$page = max($page, 1); 
$page = min($page, $totalPages); 
$offset = ($page - 1) * $limit;
if( $offset < 0 ) $offset = 0;

$tab= array_slice($tab, $offset, $limit );
               
                  
            

$NbrCol = 3;
$NbrLigne=3;
echo '<table border="0" width="430">';
echo '<h2>';
echo "<tr>";
echo "<td>";
echo "<h2>Prenom</h2>";
echo "</td>";
echo "<td>";
echo "<h2>Nom</h2>";
echo "</td>";
echo "<td>";
echo "<h2>Score</h2>";
echo "</td>";
echo "</tr>";
echo '</h2>';
for ($i=0; $i< $NbrLigne; $i++) {
  if (!empty($tab[$i]['prenom']) and isset($tab[$i]['prenom'])) {

   echo '<tr>';
           
              echo '<td>';

                echo $tab[$i]['prenom'];                  
                echo '</td>';
                echo "<td>";
                echo $tab[$i]['nom'];
                echo "</td>";
                echo "<td>";
                echo $tab[$i]['score'];
                echo "</td>";
 
            
   echo '</tr>';
  }  

}

echo '</table>';
echo "<br>";              
  $link = 'listejoueurs.php?page=%d';
$pagerContainer = '<div style="width:300px;">';   
if( $totalPages != 0 ) 
{
  if( $page == 1 ) 
  { 
    $pagerContainer .= ''; 
  } 
  else 
  { 
    $pagerContainer .= sprintf( '<button style="background-color:#828180;"><a style="font-size :25px;color:white;text-decoration:none;" href="' . $link . '" style="color:#828180;"> &#171; Precedent</a></button>', $page - 1 ); 
  }
  $pagerContainer .= ' <span> <strong> page' . $page . '</strong> sur  ' . $totalPages . '</span>'; 
  if( $page == $totalPages ) 
  { 
    $pagerContainer .= ''; 
  }
  else 
  {

 

    $pagerContainer .= sprintf( ' <button  type="submit" style="background-color:#51BFD0;"><a onclick="javascript:submitform();"name="suivant" id="suivant" style="font-size :25px;color:white;text-decoration:none;" href="' . $link . '" style="color:#97D12F" > Suivant &#187; </a></button>', $page + 1 ); 

  }           
}                   
$pagerContainer .= '</div>';

echo $pagerContainer; 
       ?>    

        <!--  fin des questions  -->
          
       </div>
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


    





