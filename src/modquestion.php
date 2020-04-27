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
  <?php 
      $selected='selected="selected"';
      (isset($_POST['liste'])) ? $liste=$_POST['liste'] : $liste="";
     ?>

  <div class="droite">
     <div class="droite-content">
      <div class="haut">
       <span style="font-size: 20px;">Modifier  question ? </span>
       
      </div>
       <div id="bleu">
 
 <?php 
$json_data = file_get_contents('../json/question.json');
$data = json_decode($json_data, true);
$id=$_GET['id'];
$pos=TrouvePositionquestion($id,'../json/question.json');

 ?>
 <form method="post" name="formulaireDynamique">
                  <label for="questions" style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Questions  </label>
                  <input type="textarea" name="question" required="" aria-required="true" value="<?php  echo $data[$pos][0]["question"] ?>" style="width: 70%; height: 90px;margin-left: 5%;margin-top: 5%; border-radius: 5px;background-color:#F4F4F4; "> <br><br>

                   <label for="score" style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Nbre de Points</label>
                  <input type="number" name="score" required="" aria-required="true" value="<?php echo $data[$pos][0]["score"]?>" min="1" style="width: 10%; height:30px;margin-left: 2%;margin-top: 5%;background-color:#F4F4F4;border:1px;border-style:solid;border-color:  #51BFD0 ;" > <br><br>

                  <label for="score" style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Type de reponse  </label>
                     <select name="liste" value="<?php echo $data[$pos][0]["liste"]?>" onchange="submit();" style="width: 60%; height:35px;margin-left: 2%%;margin-top: 5%;background-color:#F4F4F4;">
                       <option> Choisissez une reponse  </option>
                       <option  <?php if($liste=="Choix Multiple") echo $selected; ?> > Choix Multiple</option>
                      <option <?php if ($liste=="Choix simple") echo $selected; ?>> Choix simple</option>
                      <option <?php if ($liste=="Choix texte") echo $selected; ?>> Choix texte</option>
                     </select>  
                    


  <?php 
          if ($liste=="Choix texte") 
              { 
  ?><br><br>
  <label for="reponsetexte" style="font-size: 21px;font-weight: bold;margin-left: 2%;" >Reponse</label>
  <input type="text" name="texte" style="width:60%; height:30px;background-color:#F4F4F4; margin-left:30%;
  " > <br>
  <?php 
  } 
  
   if ($liste=="Choix simple") 
  {
    ?> 
       <img src="../Images/Icônes/ic-ajout-réponse.png" style="position: absolute;margin-top: 4.3%;margin-left:1%;" onclick="ajoutS(this)">
 <?php 
  }


if ($liste=="Choix Multiple") 
  {
    ?>
       <img src="../Images/Icônes/ic-ajout-réponse.png" style="position: absolute;margin-top: 4.3%;margin-left:1%;" onclick="ajoutM(this)">
 <?php 
  }


  ?>

                      <input type="submit" name="valider" value="Modifier" style="color: white; background-color: #51BFD0;width: 20%; height: 40px; border-radius: 5px;font-size: 15px;margin-top:10%;margin-left:75%;position: relative;">

          </form>






           
       </div>
       
     </div>
  </div>
         

        
  </div>

  </div>

</div>


<?php

if (isset($_POST['valider'])) 
{

    if (!empty($_POST['question']) and !empty($_POST['score']) ) 

     {
        if (($liste=="Choix texte" and !empty($_POST['texte'])) or ($liste=="Choix simple" and !empty($_POST['champs'])) or ($liste=="Choix Multiple" and !empty($_POST['champs'])) ) 

        {
           $data[$pos][0]=$_POST;
        // debut d enregistrement 
            $contenu_json = json_encode(array_values($data));
                             
file_put_contents('../json/question.json', $contenu_json);
echo '<script type="text/javascript">alert("Modifiation reuissie");</script>';

//  recharger la page : 
//header('Location:listequestions.php');           
                      // fin d'enregistrement 
        echo '<script type="text/javascript" >alert("Ajout de question reuissi :)  ")</script>';
            $tempArray=array();
            $inp = file_get_contents('../json/question.json');
            $tempArray = json_decode($inp,true);
            //var_dump($tempArray);
        }
        else
        {
          echo '<script type="text/javascript" >alert(" Question non ajoutee ,Veuillez revoir vos donnees  :(   ") </script>';
        }
      
  
    }
else
    {
      echo '<script type="text/javascript" >alert(" Question non ajoutee ,Veuillez revoir vos donnees  :(  ")</script>';
    }


//unset($_SESSION['qcm' ]);


}
function TrouvePositionquestion($element,$file) {
  $tempArray=array(); $pos=-1;
 $inp = file_get_contents($file);
$tempArray = json_decode($inp,true);
   $nbr=count($tempArray);
        for ($i=0; $i < $nbr ; $i++) 
          {
             if ($tempArray[$i][0]['question']==$element ) 
               {
                  
                 $pos=$i;
                  break;
                }
             
           }

       return $pos;          
}
 ?>
</body>
</html>



<script type="text/Javascript" >
    var j=-1;
   function ajoutM(element){
    j++;
      var formulaire = window.document.formulaireDynamique;
      // On clone le bouton d'ajout
      var ajout = element.cloneNode(true);
      // Crée un nouvel élément de type "input"
      var champ = document.createElement("input");
      var sel = document.createElement("input");

      // Les valeurs encodée dans le formulaire seront stockées dans un tableau

      champ.name = "champs[]";
      champ.type = "text";
      champ.style="width:60%; height:30px;margin-left:31%; border-radius: 2px;background-color:#F4F4F4;";
      
      sel.name = "sels[]";
      sel.type = "checkbox";
      sel.style="background-color:#F4F4F4;border: 0.1em solid #000;border-radius:40%;";
      sel.value=j;
      var sup = document.createElement("img");
      sup.src = "../Images/Icônes/ic-supprimer.png";
      // Ajout de l'événement onclick
      sup.onclick = function onclick(event)
         {suppression(this);};
        
      // On crée un nouvel élément de type "p" et on insère le champ l'intérieur.
      var bloc = document.createElement("p");
      bloc.appendChild(champ);
      bloc.appendChild(sel);
    //  formulaire.insertBefore(ajout, element);
      formulaire.insertBefore(sup, element);
      formulaire.insertBefore(bloc, element);
   }
   
   // ajout simple 
    function ajoutS(element){
       j++;
      var formulaire = window.document.formulaireDynamique;
      // On clone le bouton d'ajout
      var ajout = element.cloneNode(true);
      // Crée un nouvel élément de type "input"
      var champ = document.createElement("input");
      var sel = document.createElement("input");

      // Les valeurs encodée dans le formulaire seront stockées dans un tableau

      champ.name = "champs[]";
      champ.type = "text";
      champ.style="width:60%; height:30px;margin-left:31%; border-radius: 2px;background-color:#F4F4F4;";
      
      sel.name = "sels[]";
      sel.type = "radio";
      sel.style="background-color:#F4F4F4;";
      sel.value=j;

      var sup = document.createElement("img");
      sup.src = "../Images/Icônes/ic-supprimer.png";
      // Ajout de l'événement onclick
      sup.onclick = function onclick(event)
         {suppression(this);};
        
      // On crée un nouvel élément de type "p" et on insère le champ l'intérieur.
      var bloc = document.createElement("p");
      bloc.appendChild(champ);
      bloc.appendChild(sel);
    //  formulaire.insertBefore(ajout, element);
      formulaire.insertBefore(sup, element);
      formulaire.insertBefore(bloc, element);
   }
   // fin ajout simple 

   function suppression(element){
   var formulaire = window.document.formulaireDynamique;
        j--; 
   // Supprime le bouton d'ajout
  // formulaire.removeChild(element.previousSibling);
   // Supprime le champ
   formulaire.removeChild(element.nextSibling);
   // Supprime le bouton de suppression
   formulaire.removeChild(element);
}


</script>
<!--menu side bar-->


    





