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
	<link rel="stylesheet" type="text/css" href="../css/listejoueurs.css?v=1">

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
       <strong style="top:5%;margin-left: 12%;font-size: 25px;"> Modification </strong> 
       <div id="bleu">
       	
           <?php echo '<h2 style="margin-left:20%;"> Modifier le joueur '.$_GET['id'].'  </h2>'; 
$json_data = file_get_contents('../json/gamers.json');
$data = json_decode($json_data, true);
           echo "<br>";
      $id=$_GET['id'];
       $pos=TrouvePositionLogin($id,'../json/gamers.json');
      $s=$data[$pos]['prenom'];
      $n=$data[$pos]['nom'];
      $co=$data[$pos]['score'];


      echo '<form method="post">';
      echo "<h2>";
      echo '<span style="margin-left:5%;">Prenom :</span>';
      echo '<input type="text" name="prenom" value="'.$s.'" style="width:50%; height:30px; border-radius: 2px;background-color:#F4F4F4;margin-left:2%;"/>';
      echo "</h2>";
      echo "<br>";
      echo "<h2>";
      echo '<span style="margin-left:13%;">nom :</span>';
      echo '<input type="text" name="nom" value="'.$n.'" style="width:50%; height:30px; border-radius: 2px;background-color:#F4F4F4;margin-left:2%;"/>';
      echo "</h2>";
      echo "<br>";
      echo "<h2>";
      echo '<span style="margin-left:10%;">Score :</span>';
      echo '<input type="text" name="score" value="'.$co.'" style="width:50%; height:30px; border-radius: 2px;background-color:#F4F4F4;margin-left:2%;"/>';
      echo "</h2>";

       echo '<input type="submit" name="modifier" value="Modifier" style="background-color:#51BFD0; width:20%;color:white;margin-left:35%;font-size:20px;" />';

      echo '</form>';
          

if (isset($_POST['modifier'])) {

 //echo '<script type="text/javascript">alert("salut");</script>';
   if ( !empty($_POST['prenom']) and !empty($_POST['nom']) and !empty($_POST['score'])) {
     $data[$pos]['prenom']=$_POST['prenom'];
     $data[$pos]['nom']=$_POST['nom'];
     $data[$pos]['score']=$_POST['score'];
     $contenu_json = json_encode(array_values($data));
                             
file_put_contents('../json/gamers.json', $contenu_json);
echo '<script type="text/javascript">alert("Modifiation reuissie");</script>';

//  recharger la page : 
header('Location:Listejoueurs.php'); 
   }

   else {
echo '<script type="text/javascript">alert("Verifier les infos ");</script>';
   }
}



           ?>


          
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


    








<?php



function TrouvePositionLogin($element,$file) {
  $tempArray=array(); $pos=-1;
 $inp = file_get_contents($file);
$tempArray = json_decode($inp,true);
   $nbr=count($tempArray);
        for ($i=0; $i < $nbr ; $i++) 
          {
             if ($tempArray[$i]['prenom']==$element ) 
               {
                  
                 $pos=$i;
                  break;
                }
             
           }

       return $pos;          
}
 ?>