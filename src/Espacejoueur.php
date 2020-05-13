
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

  <?php include("header1.php"); ?>  

<div class="inset">
  <div class="login-head">
    <div class="degrade"><img class="profiler" src="../images/avatar/<?php if (isset($_SESSION['avatar'])) {echo $_SESSION['avatar'];} ?>">
    <span id="pnom"><?php if (isset($_SESSION['nom']) and isset($_SESSION['prenom']) )
    {
    echo $_SESSION['prenom'].' '.$_SESSION['nom'] ; }?></span> </div>
    <h1> BIENVENUE SUR LA PLATEFORME DE JEU DE QUIZZ <br>JOUER ET TESTER VOTRE NIVEAU DE CULTURE GENERALE </h1>
    
     <button class="deconnect" type="button" name="deconnect" value="Deconnexion"><a style="text-decoration: none;color:white;" href="deconnect.php"> Deconnexion</a></button>
         
  </div>
<?php 
       
        $inp = file_get_contents('../json/nombre.json');
        $tab= json_decode($inp,true);
        $nq=intval($tab[0]['nombre']);
        
        ?>
  <div id="milieu">
     
    <div class="droite">
        <div class="droite-content">
      
           <div id="bleu">
              
              <?php

 
   $inp = file_get_contents('../json/quest.json');
                $Quest= json_decode($inp,true);
                
                  $index=0;
                $nbr=count($Quest);


// je vais recuperer le les id de questions deja joues 
 $inp = file_get_contents('../json/qjou.json');
                $dat= json_decode($inp,true);
                $tabrep=array();
     $po=TrouvePositionLogin($_SESSION['login'],'../json/qjou.json');
     if ($po==-1) {
       $qjoues = array('login' =>$_SESSION['login'],
                  'tab' =>$tabrep );
        
        var_dump($qjoues);
       array_push( $dat,$qjoues);
        $contenu_json = json_encode($dat);
        file_put_contents('../json/qjou.json', $contenu_json);
        $po=TrouvePositionLogin($_SESSION['login'],'../json/qjou.json');
     }

     $tabrep=$dat[$po]['tab'];
     $nrep=count($tabrep);        


// on va mettre dans une variable $nquestions les qjuestions qui devvront s afficher 
if (isset($_SESSION['choisi'])) {
unset($_SESSION['choisi']);
}

$_SESSION['choisi']=array();

//var_dump($tabrep);
$f=false;
$i=0;
$a=0;
while ($f==false ) { 
          
            
           if ( verif($a,$tabrep)==false) 
           {
           $_SESSION['choisi'][$i]=$a;
            $i++;
           }
           if (count($_SESSION['choisi'])==$nq or $a==($nbr-1) ){
            $f=true;
           }
           $a++;
      }
//var_dump($_SESSION['choisi']);      
/*$min = 1;
$max = $nbr-1;    
      for ($i = 0; $i<5; $i++){
    while (in_array($a = mt_rand($min, $max), $choisi) and in_array($a,$tabrep));
    $choisi[]=$a;

}*/


if (count($_SESSION['choisi'])==$nq) 
  {
   for ($i=0; $i <$nq ; $i++) 
   { 
  $Questions[$i]=$Quest[$_SESSION['choisi'][$i]];
   }


  }
  else {
    $Questions=array();
  }


if (count($Questions)==$nq) {
$_SESSION['quest']=$Questions;
$nbr1=count($Questions);

 // a partir de la on va commencer la pagination                  

$page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
$total = count($Questions);  
$limit = 1; //par page    
$totalPages = ceil( $total/ $limit ); 
$page = max($page, 1); 
$page = min($page, $totalPages); 
$offset = ($page - 1) * $limit;
if( $offset < 0 ) $offset = 0;

$Questions= array_slice($Questions, $offset, $limit );

  
// fin pagination  


                  echo '<div class="quest" >';
                  echo '<span style="text-decoration : underline; font-size:50px;font-weight:bold;margin-bottom:5px;">';
                    echo ' Question '.($page).'/'.$nq;
                  echo '</span>';
                  echo "<br>"; 
                  
                  echo $Questions[$index][0]['question'];
                    
                  echo '</div>';
                   ?>
                  <div for="score" class="score" >  
                  <?php echo $Questions[$index][0]['score']; echo " pts"; ?>
                    </div>
                    <?php 
                    echo '<form method="post">';
                 // si le choix est simple 
                  echo "<h2>";
                    if ($Questions[$index][0]['liste']=="Choix simple") {
                          
                          
                           for($i=0; $i < count($Questions[$index][0]['champs']) ; $i++)
                            { 
                              ?>
                       <input type="radio" name="answera[]" value="<?php echo $i ;?>" style="margin-left:40%;" <?php if(isset($_SESSION['ch'][$page]) and in_array($i, $_SESSION['ch'][$page])) echo 'checked="checked"'; ?> />  
                       <?php

                           echo $Questions[$index][0]['champs'][$i];echo "<br><br>";
                               }
                           //  echo '</form>'; 

                        
                    }
                    echo "</h2>";   
                    
                   // si le choix est multiple
                    echo "<h2>";  
                    if ($Questions[0][0]['liste']=="Choix Multiple") {

                          //echo '<form method="post">';
                        
                           for($i=0; $i < count($Questions[$index][0]['champs']) ; $i++)
                            { ?> 

                        <input type="checkbox" name="answerc[]" value="<?php echo $i ;?>" style="margin-left:40%" <?php if(isset($_SESSION['ch'][$page])  and in_array($i, $_SESSION['ch'][$page])) echo 'checked="checked"'; ?> />
                        <?php
                           echo $Questions[$index][0]['champs'][$i];echo "<br><br>";
                               }
                             //echo '</form>';    
                          }
                    echo "</h2>";

                    // si le choix est texte
                     echo "<h2>";   
                    if ($Questions[$index][0]['liste']=="Choix texte") {
                      $t=1;
                      //echo '<form method="post">';
                      ?>
                      <div style="margin-left:10%;margin-top:8%;padding-bottom:4%;">
                         <span>Donnez la reponse : </span>
                       <input type="text" name="textreponse" id="<?php echo $t ;?>" value="<?php if (isset($_SESSION['ch'][$page]) ) echo htmlentities($_SESSION['ch'][$page]);?>" style="width:40%; height:30px; border-radius: 20px;background-color:#F4F4F4;"/>
                       <div> 
                       <?php   
                        }     
                        echo "</h2>";               



// debut de la pagination   
  $link = 'espacejoueur.php?page=%d';
$pagerContainer = '<div style="width:100%;margin-left:30%">';   
if( $totalPages != 0 ) 
{
  if( $page == 1 ) 
  { 
    $pagerContainer .= ''; 

  } 
  else 
  { 
    
    $pagerContainer = '<div style="">';
    $pagerContainer .= sprintf( '<input  type="submit" id="pr"  name="precedent" value="Precedent">', $page - 1 ); 
  }
  $pagerContainer .= ' <span style="margin-right:15%">  </span>'; 
 if( $page == $totalPages ) 
  { 
    $pagerContainer .= ''; 
    echo '<input  type="submit" id="ter"  name="terminer" value="Terminer">';
  }
  else 
  {
 
    $pagerContainer .= sprintf( '<input  type="submit" id="sv"  name="suivant" value="Suivant">', $page + 1 ); 

  }           
}                   
$pagerContainer .= '</div>';

echo $pagerContainer;
echo '<input  type="submit" id="quit"  name="quitter" value="Quitter">';
echo '</form>';
// fin de la pagination 
  
  }  

  else{

       echo '<div class="fin">';
   echo "</h2>Vous avez quasiment joue a toute les questions ,bref revenez quand il y aura de nouvelles questions , merci </h2>";
   echo '<div>';
   //unset($_SESSION['choisi']);


  }
    
$_SESSION['no']=$nq;

// fonction qui verifie si l utilisateur a donne une reponse ou non 


?>








<?php


if (isset($_POST['suivant'])) {

$_SESSION['reponse'][$page]=$_POST;

if (count($_POST)==1 or (isset($_POST['textreponse']) and $_POST['textreponse']=='') ) {
  $_SESSION['nonrep'][]=($page);
}


if (isset($_POST['answerc'])) {
   
     $_SESSION['ch'][$page]=$_POST['answerc'];
  }
if (isset($_POST['answera'])) {
     $_SESSION['ch'][$page]=$_POST['answera'];
   }   
if (isset($_POST['textreponse'])) {
  $_SESSION['ch'][$page]=$_POST['textreponse'];
}
  
  /*echo '<script type="text/javascript" >alert("salut  ")</script>'; */
header('location:espacejoueur.php?page='.($page+1));
 } 

 if (isset($_POST['precedent'])) {
  if (isset($_POST['answerc'])) {
   
     $_SESSION['ch'][$page]=$_POST['answerc'];
  }
if (isset($_POST['answera'])) {
     $_SESSION['ch'][$page]=$_POST['answera'];
  } 

 if (isset($_POST['textreponse'])) {
  $_SESSION['ch'][$page]=$_POST['textreponse'];
}

  header('location:espacejoueur.php?page='.($page-1));
 } 
if (isset($_POST['terminer']) or isset($_POST['quitter']) ) { 
if (count($_POST)==1 or (isset($_POST['textreponse']) and $_POST['textreponse']=='') ) {
  $_SESSION['nonrep'][]=($page);
}

     
   $_SESSION['reponse'][$page]=$_POST;
   header('location:resultat.php');
  
}

?>


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

                $inp = file_get_contents('../json/joueurs.json');
                $tab= json_decode($inp,true);
                $tab=triBulleDecroissant($tab);
                $NbrCol = 3;
$NbrLigne=5;
echo '<table border="0"  class="tabl">';
$couleur = array('#50DAC2','#6AD7D1','#F8B106','#EF7E05','#EEEEEE');

for ($i=0; $i< $NbrLigne; $i++) {
  if (!empty($tab[$i]['prenom']) and isset($tab[$i]['prenom'])) {

   echo '<tr>';
           
              echo '<td >';

                echo $tab[$i]['prenom'];                  
                echo '</td>';
                echo '<td >';
                echo $tab[$i]['nom'];
                echo "</td>";
                echo '<td >';
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
                  <p style="font-size: 18px;font-weight: bold;"><?php 
$json_data = file_get_contents('../json/joueurs.json');
$data = json_decode($json_data, true);
$id=$_SESSION['login'];
$pos=TrouvePositionLogin($id,'../json/joueurs.json');
$score=$data[$pos]['score'];

                  if (isset($_SESSION['nom']) and isset($_SESSION['prenom']) )
    {
     echo $_SESSION['prenom'].' '.$_SESSION['nom'].'  '.$score.' pts' ; }?>
                  </p>
                </div>
  
              </div>
      
          </div><!--  fin div score -->
      
        </div> <!-- fin div milieu  -->
   
     </div>

  </div>

</div> <!-- fin div container -->



<?php  



?>


</body>
</html>

<?php



function TrouvePositionLogin($element,$file) {
  $tempArray=array(); $pos=-1;
 $inp = file_get_contents($file);
$tempArray = json_decode($inp,true);
   $nbr=count($tempArray);
        for ($i=0; $i < $nbr ; $i++) 
          {
             if ($tempArray[$i]['login']==$element ) 
               {
                  
                 $pos=$i;
                  break;
                }
             
           }

       return $pos;          
}
 function verif($el,$tab) {
  $t=false;
  for ($i=0; $i <count($tab) ; $i++) { 
    if ($tab[$i]==$el) {
      $t=true;
      break;
    }

  }
  return $t;
 }
//http://localhost/sacademy/TP3GIT/Miniprojetqm/src/EspaceJoueur.php
 ?>

<!--menu side bar-->


 




