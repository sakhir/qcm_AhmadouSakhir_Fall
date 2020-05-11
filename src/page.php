
<?php 
       
        $inp = file_get_contents('../json/nombre.json');
        $tab= json_decode($inp,true);
        $nb=intval($tab[0]['nombre']);
        
        ?>
<!--menu side bar-->
  

  <div class="droite">
     <div class="droite-content">
      <div class="haut">
        <form method="post"> 
       <label style="font-size: 20px;">Nbre de question/jeu </label>
       <!-- <input type="text" name="nbrq" value="5" style="width: 10%;height: 15%;"> -->
       <input type="number"  name="nombre"  value="<?php echo $nb ?>" min="5" style="width: 10%; height:15%;" >
       <input type="submit" name="ok" value="OK" style="background-color:#5e90af;font-size: 20px;color: white; ">
       </form>
      </div>
   <?php 
        if (isset($_POST['ok'])) {
        $inp = file_get_contents('../json/nombre.json');
        $tab= json_decode($inp,true);
        $tab[0]['nombre']=intval($_POST['nombre']);
        $contenu_json = json_encode(array_values($tab));
        file_put_contents('../json/nombre.json', $contenu_json);
        echo '<script type="text/javascript">alert("nombre mis a jour");</script>';
        }
        
        ?>
       <div id="bleu">

       
         <!-- debut des questions -->
         <?php 
 // partie liste questions:
  $inp = file_get_contents('../json/quest.json');
  $Questions= json_decode($inp,true); 
  $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
$total = count($Questions);  
$limit = 2; //par page
   
$totalPages = ceil( $total/ $limit ); 
$page = max($page, 1); 
$page = min($page, $totalPages); 
$offset = ($page - 1) * $limit;
if( $offset < 0 ) $offset = 0;

$Questions= array_slice($Questions, $offset, $limit );


$NbrLigne=3;
echo '<table border="0" width="auto">';

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
                echo '<button style="background-color:red; "> <a href="supquestion.php?id='.$Questions[$i][0]['question'].'" style="text-decoration:none;color:white;font-size:100%;font-weight:bold;">Suppimer</a></button>';
    echo "</td>";  
     echo "<td>";
                echo '<button style="background-color:green"><a href="modquestion.php?id='.$Questions[$i][0]['question'].'" style="text-decoration:none;color:white;font-size:100%;font-weight:bold;">modifier</a></button>';
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

     </div>
  </div>
         



<!--menu side bar-->


    








