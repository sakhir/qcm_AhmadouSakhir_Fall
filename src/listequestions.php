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
	<link rel="stylesheet" type="text/css" href="../css/listequestion.css?v=1">
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
        <form method="post"> 
       <label style="font-size: 20px;">Nbre de question/jeu </label>
       <input type="text" name="nbrq" value="2" style="width: 10%;height: 15%;">
       <input type="submit" name="ok" value="OK" style="background-color:#5e90af;font-size: 20px;color: white; ">
       </form>
      </div>
       <div id="bleu">
         <!-- debut des questions -->
         <?php 
 // partie liste questions:
  $inp = file_get_contents('../json/question.json');
  $Questions= json_decode($inp,true);
  $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
$total = count($Questions);  
$limit = 2; //par page
if (isset($_POST['ok'])) {
  
      $limit=intval($_POST['nbrq']);
    }    
$totalPages = ceil( $total/ $limit ); 
$page = max($page, 1); 
$page = min($page, $totalPages); 
$offset = ($page - 1) * $limit;
if( $offset < 0 ) $offset = 0;

$Questions= array_slice($Questions, $offset, $limit );


$NbrLigne=3;
echo '<table border="0" width="430">';

for ($i=0; $i< $NbrLigne; $i++) {
  if (isset($Questions[$i][0]['question']) and !empty($Questions[$i][0]['question'])  ) {

   echo '<tr>';
   echo "<td>";
    echo '<h4>';
    echo ($i+1).') '.$Questions[$i][0]['question'];
    echo '</h4>'; 
    // si le choix est simple 
                  
                    if ($Questions[$i][0]['liste']=="Choix simple") {
                          echo '<form method="post">';
                          
                           for($j=0; $j < count($Questions[$i][0]['champs']) ; $j++)
                            { 
                           echo '<input type="radio" name="answera" style="margin-left:1%"/>';
                           echo $Questions[$i][0]['champs'][$j];echo "<br><br>";
                               }
                             echo '</form>';  
                             
                        
                    }
                     

    // si le choix est multiple
                     
                    if ($Questions[$i][0]['liste']=="Choix Multiple") {

                          echo '<form method="post">';
                        
                           for($j=0; $j < count($Questions[$i][0]['champs']) ; $j++)
                            {                            echo '<input type="checkbox" name="answerc" style="margin-left:1%"/>';
                           echo $Questions[$i][0]['champs'][$j];echo "<br><br>";
                               }
                             echo '</form>';    
                          }
                    

                    // si le choix est texte
                     echo "<h2>";   
                    if ($Questions[$i][0]['liste']=="Choix texte") {
                      echo '<div style="margin-left:2%;margin-top:2%;padding-bottom:4%;">';
                       echo '<input type="text" name="textreponse" style="width:70%; height:30px; border-radius: 2px;background-color:#F4F4F4;"/>';
                       echo '</div>'; 
                        }     
                        echo "</h2>";                        
     echo "</td>";  
     echo "<td>";
                echo '<button style="background-color:red"> <a href="supquestion.php?id='.$Questions[$i][0]['question'].'" style="text-decoration:none;color:white;font-size:15px;">Suppimer</a></button>';
    echo "</td>";  
     echo "<td>";
                echo '<button style="background-color:green"><a href="modquestion.php?id='.$Questions[$i][0]['question'].'" style="text-decoration:none;color:white;font-size:15px;">modifier</a></button>';
       echo '</td>';  

   echo '</tr>';
  }  

}

echo '</table>';




// debut de la pagination   
  $link = 'listequestions.php?page=%d';
$pagerContainer = '<div style="width:100%;margin-left:56%">';   
if( $totalPages != 0 ) 
{
  if( $page == 1 ) 
  { 
    $pagerContainer .= ''; 

  } 
  else 
  { 
    $pagerContainer = '<div style="width:100%;margin-left:10%">';
    $pagerContainer .= sprintf( '<button style="background-color:#828180;"><a style="font-size :30px;color:white;text-decoration:none;" href="' . $link . '" style="color:#828180;"> Precedent</a></button>', $page - 1 ); 
  }
  $pagerContainer .= ' <span style="margin-right:15%">  </span>'; 
 if( $page == $totalPages ) 
  { 
    $pagerContainer .= ''; 
  
  }
  else 
  {
 
    $pagerContainer .= sprintf( '<button  type="submit" style="background-color:#3addd6;"><a id="suivant"  style="font-size :30px;color:white;text-decoration:none;" href="' . $link . '" style="color:#97D12F" > Suivant </a></button>', $page + 1 ); 

  }           
}                   
$pagerContainer .= '</div>';

echo $pagerContainer;
?>

        <!--  fin des questions  -->
       </div>
       <!-- <button style="width: 30%;background-color:#3addd6;margin-left: 57%;margin-top:2%;font-size: 25px;color: white; ">suivant</button> -->
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


    





