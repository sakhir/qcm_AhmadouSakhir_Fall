<div class="droite">
     <div class="droite-content">
       <strong style="" class="titr"> LISTE DES JOUEURS PAR SCORE  </strong> 
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
echo '<table border="0" width="100%">';
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
echo "<td>";
echo "<h2>Action</h2>";
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
                echo '<td style="">';
                echo $tab[$i]['score'];
                echo "</td>";
                echo "<td>";
                echo '<a href="supprimer.php?id='.$tab[$i]['prenom'].'" style="text-decoration:none;"><img style="width:20%;margin-left:10%;position:relative;" src="../images/Icônes/supp1.png" alt="Supprimer" /></a>';
                echo '<a href="modifier.php?id='.$tab[$i]['prenom'].'" style="text-decoration:none;"><img style="width:20%;margin-left:15%;position:relative;" src="../images/Icônes/mod.png" /></a>';
                echo "</td>";
                    
 
            
   echo '</tr>';
  }  

}

echo '</table>';
echo "<br>"; 
echo "<br>";              
  $link = 'listejoueurs.php?page=%d';
$pagerContainer = '<div style="width:100%;margin-left:15%">';   
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
  $pagerContainer .= ' <span style="margin-left:20%;"> </span>'; 
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