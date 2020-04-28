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
         
<?php include("pagelistejoueur.php"); ?>  
        
</div>

  </div>

</div>


</body>
</html>



