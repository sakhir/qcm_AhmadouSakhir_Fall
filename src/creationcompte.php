<?php include("islogged.php"); ?>  

<!DOCTYPE html>
<html>
<head>
  <title> Creation Compte</title>
  <link rel="stylesheet" type="text/css" href="../css/creationcompte.css?v=1">
</head>
<body>

<div id="container">
 <?php include("header1.php"); ?>  
   

 <div class="inset">
<?php include("header2.php"); ?>   
  
<div id="milieu">
<?php $nav_en_cours = "creercompte"; ?>    
<?php include("menu.php"); ?>    
         
<?php include("pagecompte.php"); ?>  
        
</div>

  </div>

</div>


</body>
</html>




<?php  
if (isset($_POST['register'])) {

  $tableauAdmin = array(
   'prenom' => $_POST['prenom'],
   'nom' => $_POST['nom'],
   'login' => $_POST['login'],
   'mdp' => $_POST['password'],
   'confirm_password' => $_POST['confirm_password'],
   'avatar'  =>$_FILES['avatarfile']['name']
);

// debut validation inscription
 if (!empty($_POST['prenom'])and !empty($_POST['nom'])and !empty($_POST['login'])and !empty($_POST['password']) and !empty($_POST['confirm_password'])) 
        {     
          $pwd1=$_POST['password'];
          $pwd2=$_POST['confirm_password'];
              
              $loginexist =ChercheLogin($_POST['login'],'../json/admin.json');
              if ($loginexist==false) 
              {
                  if ($pwd1==$pwd2) 
                    {   
                     // debut changement     
                      if (isset($_FILES['avatarfile']) and !empty($_FILES['avatarfile']['name']))
{
  $extansionsvalides= array('jpg','jpeg','png');

     $extansionupload=strtolower(substr(strrchr($_FILES['avatarfile']['name'], '.'), 1));
      if(in_array($extansionupload,$extansionsvalides)) {
            $chemin="../images/avatar/";
            $uploadfile = $chemin . basename($_FILES['avatarfile']['name']);
            $resultat=move_uploaded_file($_FILES['avatarfile']['tmp_name'], $uploadfile);
            if($resultat) {
               // debut d enregistrement 
                      try {
                        // On essayes de récupérer le contenu existant
                            $s_fileData = file_get_contents('../json/admin.json');
                             
                            if( !$s_fileData || strlen($s_fileData) == 0 ) {
                                // On crée le tableau JSON
                                $tableau_pour_json = array();
                            } else {
                                // On récupère le JSON dans un tableau PHP
                                $tableau_pour_json = json_decode($s_fileData, true);
                            }
                             
                            // On ajoute le nouvel élement
                            array_push( $tableau_pour_json,$tableauAdmin);
                            // On réencode en JSON
                            $contenu_json = json_encode($tableau_pour_json);
                             
                            // On stocke tout le JSON
                            file_put_contents('../json/admin.json', $contenu_json);

                         
                      
                        }
                        catch( Exception $e ) {
                            echo "Erreur : ".$e->getMessage();
                        }
                      // fin d'enregistrement 
                          echo '<script type="text/javascript">alert("Admin  bien ajouté");</script>';
                         //var_dump($contenu_json); 

             }   
              else { 

                echo '<script type="text/javascript">alert("erreur durant  importation de votre photo de profil ");</script>';
              }
      }
      else {
        echo '<script type="text/javascript">alert("votre photo de profil doit etre au format jpg,jpeg ou png");</script>';
      }
     
   
}// fin isset avatarfile
else {
   echo '<script type="text/javascript">alert("Choisissez une photo de profil ");</script>';
}
                      
                       //fin changement 
                                        
                    } 
                 else
                    {
                       echo '<script type="text/javascript">alert("les mots de pass ne correspondent pas , essayez encore");</script>';
                    }
             }
             else
              {
                 echo '<script type="text/javascript">alert("Login deja utilisé");</script>';
              }
        
        }
      else
      {
        
         echo '<script type="text/javascript">alert("remplir tous les champs");</script>';
      }

}


// je dois creer une fonction qui verifie si le pseudo de l'utilisateur existe dans le fichier  json 
function ChercheLogin($log,$file) {
$tempArray=array();
$inp = file_get_contents($file);
$tempArray = json_decode($inp,true);

if (!empty($tempArray)) { 
  
  for ($i=0; $i <count($tempArray) ; $i++) { 
     if ($tempArray[$i]['login']==$log) {
       return true ;
     }
   } 
  
 }
return  false;
}

?>


