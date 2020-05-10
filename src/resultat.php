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

  <meta http-equiv="Content-Type" content="text/html charset=UTF-8"/>
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

  <div id="milieu">
     
    <div class="droite">
        <div class="droite-content">
      
           <div id="bleu">
              
              <?php
$Questions=$_SESSION['quest'];
//var_dump($Questions);
    $q=count($Questions);
    $tabmauvrep=array();
    $tabonrep=array();
  // donc ici  on va commencer le traitement pour donner le score d ju joueur :
  $numcorrect=0; // variable qui se charge de calculer le nombre de reponse correct
 $score=0;
for ($i=1; $i <($q+1) ; $i++) 
{ 
  if  (isset($_SESSION['reponse'][$i]['answera']) ) {

      if ( $_SESSION['reponse'][$i]['answera'][0]==$Questions[$i-1][0]['sels'][0]) {
      $numcorrect++;
      $score+=intval($Questions[$i-1][0]['score']);
      array_push($tabonrep, $i);
    
      }
      else {
        array_push($tabmauvrep, $i);
      }

      

    }
    elseif ( isset($_SESSION['reponse'][$i]['textreponse']) )
     {
       if ($_SESSION['reponse'][$i]['textreponse']==$Questions[$i-1][0]['texte']) {
      $numcorrect++;
      $score+=intval($Questions[$i-1][0]['score']);
      array_push($tabonrep, $i);
  
       }
      else {
        array_push($tabmauvrep, $i);
      }


    }
 else {
  if (isset($_SESSION['reponse'][$i]['answerc'])){
  $rp=count($_SESSION['reponse'][$i]['answerc']);
 
   $tr=true;
  for ($j=0; $j <$rp; $j++) { 

    if ($_SESSION['reponse'][$i]['answerc'][$j]!=$Questions[$i-1][0]['sels'][$j] or count($_SESSION['reponse'][$i]['answerc'])!=count($Questions[$i-1][0]['sels'])) {
      $tr=false;
      break;
    }
  }
  if ($tr==true) {
    $numcorrect++;
    $score+=intval($Questions[$i-1][0]['score']);
    array_push($tabonrep, $i);
  }
  else {
        array_push($tabmauvrep, $i);
  }
  }
 }
    
}

 // on va mettre dans le tableau reponses non repondues 

 
   
 

                echo '<div class="quest" >';
                 if (isset($_SESSION['reponse'])) {
                 $nb=count($Questions);
              echo "<h3>vous avez trouve $numcorrect reponse(s) sur $nb et votre score est : $score</h3>";
             

                    
                  }          
                    echo '</div>';

  // donc la on va sauvegarder le score de l utilisateur 
  $json_data = file_get_contents('../json/joueurs.json');
$data = json_decode($json_data, true);
$lo=$_SESSION['login'];

$pos=TrouvePositionLogin($lo,'../json/joueurs.json');
$sc=$data[$pos]['score'];
if ($score>$sc) {
  $data[$pos]['score']=$score;
  echo '<script type="text/javascript" >alert(" Score mis a jour (:  ") </script>';

}

        // debut d enregistrement 
            $contenu_json = json_encode(array_values($data));
                             
          file_put_contents('../json/joueurs.json', $contenu_json);
                  
  // a partir de la on va essayer d affichier les mauvaises reponses    
    /* echo "<pre>";              
    print_r($tabmauvrep);
    echo "</pre>"; */
  
     if (isset($tabmauvrep) and count($tabmauvrep)>=1) {
     echo '<div class="recap">';
     $i=0;
    while ( isset($tabmauvrep[$i])) {
     echo $Questions[$tabmauvrep[$i]-1][0]['question'];echo '<img src="../images/faux.png" style="margin-left:10%;" /><br>';
         if ($Questions[$tabmauvrep[$i]-1][0]['liste']=="Choix texte") {
           echo 'la reponse est : '.$Questions[$tabmauvrep[$i]-1][0]['texte'].'<br>';
         }
        elseif ($Questions[$tabmauvrep[$i]-1][0]['liste']=="Choix simple") {
          $ind=intval($Questions[$tabmauvrep[$i]-1][0]['sels'][0]);
          echo 'la reponse est : '.$Questions[$tabmauvrep[$i]-1][0]['champs'][$ind].'<br>';
        }
        else {
           $taille=count($Questions[$tabmauvrep[$i]-1][0]['sels']);
           echo "la ou les bonnes reponses est/sont : <br>";
            for ($t=0; $t <$taille; $t++) { 
              $in=intval($Questions[$tabmauvrep[$i]-1][0]['sels'][$t]);
               echo $Questions[$tabmauvrep[$i]-1][0]['champs'][$in].'<br>';

            }
        }
     $i++;
    }
    
     echo '</div>';
    
     }
       if (isset($_SESSION['nonrep']) and count($_SESSION['nonrep'])>=1) {

         echo "<h4>les questions non repondues :</h4>";  
     // ici on va essayer d'afficher les bonnes questions non repondues  :
        echo '<div  class="nonrep"> ';
       $i=0;
    while ( isset($_SESSION['nonrep'][$i+1])) {
     echo $Questions[$_SESSION['nonrep'][$i]-1][0]['question'];echo '<img src="../images/faux.png" style="margin-left:10%;" /><br>';
         if ($Questions[$_SESSION['nonrep'][$i]-1][0]['liste']=="Choix texte") {
           echo 'la reponse est : '.$Questions[$_SESSION['nonrep'][$i]-1][0]['texte'].'<br>';
         }
        elseif ($Questions[$_SESSION['nonrep'][$i]-1][0]['liste']=="Choix simple") {
          $ind=intval($Questions[$_SESSION['nonrep'][$i]-1][0]['sels'][0]);
          echo 'la reponse est : '.$Questions[$_SESSION['nonrep'][$i]-1][0]['champs'][$ind].'<br>';
        }
        else {
           $taille=count($Questions[$_SESSION['nonrep'][$i]-1][0]['sels']);
           echo "la ou les bonnes reponses est/sont : <br>";
            for ($t=0; $t <$taille; $t++) { 
              $in=intval($Questions[$_SESSION['nonrep'][$i]-1][0]['sels'][$t]);
               echo $Questions[$_SESSION['nonrep'][$i]-1][0]['champs'][$in].'<br>';

            }
        }
     $i++;
    }

   echo '</div>';

      }
        if (isset($tabonrep) and count($tabonrep)>=1) {
       // donc la je vasi afficher les questions trouvees  
          echo "<h4>les reponses trouvees :</h4>";  
          //var_dump($tabonrep);
     // ici on va essayer d'afficher les bonnes questions non repondues  :
        echo '<div  class="nonrep"> ';
       $i=0;
    while ( isset($tabonrep[$i])) {
     echo $Questions[$tabonrep[$i]-1][0]['question'];echo '<img src="../images/valider.png" style="margin-left:10%;" /><br>';
         if ($Questions[$tabonrep[$i]-1][0]['liste']=="Choix texte") {
           echo 'la reponse est : '.$Questions[$tabonrep[$i]-1][0]['texte'].'<br>';
         }
        elseif ($Questions[$tabonrep[$i]-1][0]['liste']=="Choix simple") {
          $ind=intval($Questions[$tabonrep[$i]-1][0]['sels'][0]);
          echo 'la reponse est : '.$Questions[$tabonrep[$i]-1][0]['champs'][$ind].'<br>';
        }
        else {
           $taille=count($Questions[$tabonrep[$i]-1][0]['sels']);
           echo "la ou les bonnes reponses est/sont : <br>";
            for ($t=0; $t <$taille; $t++) { 
              $in=intval($Questions[$tabonrep[$i]-1][0]['sels'][$t]);
               echo $Questions[$tabonrep[$i]-1][0]['champs'][$in].'<br>';

            }
        }
     $i++;
    }

   echo '</div>';
        }
$t=array() ;
 
 $qjoues = array('login' =>$lo,
                  'tab' =>$t );

 for ($i=0; $i <count($Questions) ; $i++) { 
   if (isset($Questions[$i][0]['id'])) {
    array_push($qjoues['tab'], $Questions[$i][0]['id']);
   }
 }
// enregistrement 

 //var_dump($qjoues);
 
 //fin enregistrement 
    echo '<form method="post">';
    echo '<input  type="submit" id="val"  name="valider" value="Valider">';   
    echo '<form>';
        if (isset($_POST['valider'])) {

         // ici je vais essayer d enregistrer les questions jouues par l utilisateur 
          try {
                        // On essayes de récupérer le contenu existant
                            $s_fileData = file_get_contents('../json/qjou.json');
                             
                            if( !$s_fileData || strlen($s_fileData) == 0 ) {
                                // On crée le tableau JSON
                                $tableau_pour_json = array();
                            } else {
                                // On récupère le JSON dans un tableau PHP
                                $tableau_pour_json = json_decode($s_fileData, true);
                            }
                             
                            // On ajoute le nouvel élement
                            $n=count($tableau_pour_json);
                            if ($n==0) {
                              array_push( $tableau_pour_json,$qjoues);
                            }
                            else {
                              for ($i=0; $i <$n ; $i++) { 
                                if ($tableau_pour_json[$i]['login']=="$lo") {
                                    for ($j=0; $j <$qjoues['tab'][$j] ; $j++) { 
                                 array_push( $tableau_pour_json[$i]['tab'],$qjoues['tab'][$j]);    
                                
                                    }
                                                
                                }
                                else {
                                    array_push( $tableau_pour_json,$qjoues);
                                    break;         
                                    }
                              }
                            }

                            
                              

                          // On réencode en JSON
                            $contenu_json = json_encode($tableau_pour_json);
                            //  var_dump($tableau_pour_json);
                            // On stocke tout le JSON
                            file_put_contents('../json/qjou.json', $contenu_json);

                          unset($contenu_json);
                      
                        }
                        catch( Exception $e ) {
                            echo "Erreur : ".$e->getMessage();
                        }

          
           unset($_SESSION['reponse']);
           unset($_SESSION['nonrep']);
           unset($_SESSION['choisi']);
           unset($_SESSION['quest']);
           unset($qjoues);


          header('location:espacejoueur.php');
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
      
          </div>
      
        </div>
   
     </div>

  </div>

</div> <!-- fin div container -->


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
function TrouverIndice ($b,$tab) {
  $tr=false;
  for ($i=0; $i <count($tab) ; $i++) { 
    if ($tab[$i]==$b) {
      $tr=true;
      break;
    }
  }
  return $tr;
}
 ?>

<!--menu side bar-->


 




