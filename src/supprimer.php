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
       <strong style="top:5%;margin-left: 12%;font-size: 25px;"> CONFIRMER SUPPRESSION  </strong> 
       <div id="bleu">
       
            <?php echo '<h2 style="margin-left:5%;"> Voulez-vous Supprimer le joueur '.$_GET['id'].' ? </h2>' ;
           
                echo '<form method="post">';
           echo '<button  type="submit" name="oui" style="background-color:#3addd6;color:white;width:40%;font-size:50px;margin-left:5%;">Oui</button>';

           echo '<button  type="submit" name="non" style="background-color:red;color:white;width:40%;font-size:50px;margin-left:1%">Non</button>';
           echo '</form>';
 if (isset($_POST['oui'])) {

$json_data = file_get_contents('../json/joueurs.json');
$data = json_decode($json_data, true);
// on vas supprimer ici 
if (isset($_GET['id'])) {
$id=$_GET['id'];
$pos=TrouvePositionLogin($id,'../json/joueurs.json');
unset($data[$pos]);


$contenu_json = json_encode(array_values($data));
                             
file_put_contents('../json/joueurss.json', $contenu_json);
echo '<script type="text/javascript">alert("Supression reuissie");</script>';

//  recharger la page : 
header('Location:listejoueurs.php'); 
}
 }

if (isset($_POST['non'])) { 

//  recharger la page : 
header('Location:listejoueurs.php'); 
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