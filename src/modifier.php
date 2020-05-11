<?php include("islogged.php"); ?>  


<!DOCTYPE html>
<html>
<head>
  <title> Liste Joueur</title>
  <link rel="stylesheet" type="text/css" href="../css/listejoueurs.css?v=1">
</head>
<body>

<div id="container">
 <?php include("header1.php"); ?>  
   

 <div class="inset">
<?php include("header2.php"); ?>   
  
<div id="milieu">
<?php $nav_en_cours = "listejoueur"; ?>      
<?php include("menu.php"); ?>    
         

  <div class="droite">
     <div class="droite-content">
       <strong style="top:5%;margin-left: 12%;font-size: 25px;"> Modification </strong> 
       <div id="bleu">
        
           <?php echo '<h2 style="margin-left:20%;"> Modifier le joueur '.$_GET['id'].'  </h2>'; 
$json_data = file_get_contents('../json/joueurs.json');
$data = json_decode($json_data, true);
           echo "<br>";
      $id=$_GET['id'];
       $pos=TrouvePositionLogin($id,'../json/joueurs.json');
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
                             
file_put_contents('../json/joueurs.json', $contenu_json);

echo '<script type="text/javascript">alert("Modifiation reuissie");</script>';

//  recharger la page : 
header('Location:listejoueurs.php'); 
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
             if ($tempArray[$i]['prenom']==$element ) 
               {
                  
                 $pos=$i;
                  break;
                }
             
           }

       return $pos;          
}
 ?>