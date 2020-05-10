<?php include("islogged.php"); ?>  


<!DOCTYPE html>
<html>
<head>
  <title> Creer question</title>
  <link rel="stylesheet" type="text/css" href="../css/creerquestion.css?v=1">
</head>
<body>

<div id="container">
 <?php include("header1.php"); ?>  
   

 <div class="inset">
<?php include("header2.php"); ?>   
  
<div id="milieu">
 <?php $nav_en_cours = "creerquestion"; ?>   
<?php include("menu.php"); ?>    
         
<?php include("pagequestion.php"); ?>  
        
</div>

  </div>

</div>


</body>


<?php  

// le traitement s il clique sur le bouton enregistgrer :
if (isset($_POST['valider'])) 
{

    if (!empty($_POST['question']) and !empty($_POST['score']) ) 

     {
        if (($liste=="Choix texte" and !empty($_POST['texte'])) or 
          ($liste=="Choix simple" and !empty($_POST['champs']) and Validerreponse($_POST['champs'])!=false and !empty($_POST['sels']) ) or ($liste=="Choix Multiple" and !empty($_POST['champs'])and Validerreponse($_POST['champs'])!=false and !empty($_POST['sels']) ) ) 

        {


           unset( $_SESSION['question']) ;

    $inp = file_get_contents('../json/quest.json');
     $Questions= json_decode($inp,true);
     $nb=count($Questions);
     if ($nb==0) {
      $_POST['id']=1;
     }

     else{
      $_POST['id']=$nb+1;
     }
           $_SESSION['question'][]=$_POST;
        // debut d enregistrement 
                      try {
                        // On essayes de récupérer le contenu existant
                            $s_fileData = file_get_contents('../json/quest.json');
                             
                            if( !$s_fileData || strlen($s_fileData) == 0 ) {
                                // On crée le tableau JSON
                                $tableau_pour_json = array();
                            } else {
                                // On récupère le JSON dans un tableau PHP
                                $tableau_pour_json = json_decode($s_fileData, true);
                            }
                             
                            // On ajoute le nouvel élement
                            array_push( $tableau_pour_json,$_SESSION['question']);
                            // On réencode en JSON
                            $contenu_json = json_encode($tableau_pour_json);
                             
                            // On stocke tout le JSON
                            file_put_contents('../json/quest.json', $contenu_json);

                         
                      
                        }
                        catch( Exception $e ) {
                            echo "Erreur : ".$e->getMessage();
                        }
                      // fin d'enregistrement 
              ?>
              
       <script type="text/javascript" >
            let q=document.getElementById("qu");
            let s=document.getElementById("sc");
           
        alert(" Ajout de question reuissi :)  ");
         q.value="";
         s.value="";
           
           
          </script>';
          
      <?php
      unset( $_SESSION['question']) ;

            $tempArray=array();
            $inp = file_get_contents('../json/quest.json');
            $tempArray = json_decode($inp,true);
            //var_dump($tempArray);
        }
        else
        { 

          echo '<script type="text/javascript" >alert(" Question non ajoutee ,Veuillez revoir vos donnees  :(   ");
           
          </script>';

        }
      
  
    }
else
    {
      echo '<script type="text/javascript" >alert(" Question non ajoutee ,Veuillez revoir vos donnees  :(  ");</script>';
    }


//unset($_SESSION['qcm' ]);


} // fin du isset 

function Validerreponse($tab) {
  $nb=count($tab);
  if ($nb>=2) {
   return true ;
  } else {
    return false ;
  }
  
}
 
?>
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

</html>
         







<!--menu side bar-->


    





