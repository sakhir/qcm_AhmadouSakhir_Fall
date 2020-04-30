<!DOCTYPE html>
<html>
<head>
	<title> Page d'inscription</title>
	<link rel="stylesheet" type="text/css" href="../css/inscription.css?v=1">

</head>
<body>
<div id="container">

  <?php include("header1.php"); ?>  

   <div class="form-v2-content">
     
      <form class="form-detail" method="post" id="myform" enctype="multipart/form-data" >
        <h2>S'inscrire</h2>
        <label>Pour tester votre niveau de culture generale</label>
        <div class="form-row">
          
          <label for="full-name">Prenom</label>
          <input type="text" name="prenom" id="full_name" required="" aria-required="true" class="input-text" placeholder="Prenom" value="<?php if (isset($_POST['prenom']) ) echo htmlentities($_POST['prenom']) ?>">
        </div>
        <div class="form-row">
          <label for="full-name">Nom</label>
          <input type="text" name="nom" id="full_name" required="" aria-required="true" class="input-text" placeholder="Nom" value="<?php if (isset($_POST['nom']) ) echo htmlentities($_POST['nom']) ?>">
        </div>
         <div class="form-row">
          <label for="full-login">Login</label>
          <input type="text" name="login" id="full_name" class="input-text" required="" aria-required="true" placeholder="Login" value="<?php if (isset($_POST['login']) ) echo htmlentities($_POST['login']) ?>">
        </div>
        <div class="form-row">
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" class="input-text" required="" aria-required="true">
        </div>
        <div class="form-row">
          <label for="comfirm-password">Confirmer Password</label>
          <input type="password" name="confirm_password" id="confirm_password" class="input-text" required="" aria-required="true">
        </div>
        <div class="form-row">
         <label for="avatar">Avatar </label>
         <input type="file" name="avatarfile" value="Choisir un fichier" id="avatar"  onchange="handleFiles(files)">
         <div><label for="upload"><span id="preview"></span></label></div>  
        </div>
        
        <div class="form-row-last">
          <input type="submit" name="register" class="register" value="Creer compte">
        </div>
      </form>
  

    <span>Avatar du joueur</span>
 
   <script>
 function handleFiles(files) {

   var imageType = /^image\//;
   for (var i = 0; i < files.length; i++) {
   var file = files[i];
   if (!imageType.test(file.type)) {
     alert("veuillez sélectionner une image");
   }else{
     if(i == 0){
       preview.innerHTML = '';
     }
      console.log(i);
     var img = document.createElement("img");
     img.classList.add("obj");
     img.file = file;
     img.style="width:80%;margin-top:-20%;margin-left:15%;height: 120%;border-radius: 50% ;border: 4px solid #51BFD0;position: absolute;";
     preview.appendChild(img); 
     var reader = new FileReader();
     reader.onload = ( function(aImg) { 
     return function(e) { 
     aImg.src = e.target.result; 
   }; 
  })(img);

 reader.readAsDataURL(file);
 }

 }
}
 </script>

</div>





<?php  
if (isset($_POST['register'])) {

  $tableaujoueurs = array(
   'prenom' => $_POST['prenom'],
   'nom' => $_POST['nom'],
   'login' => $_POST['login'],
   'password' => $_POST['password'],
   'confirm_password' => $_POST['confirm_password'],
   'avatar'  =>$_FILES['avatarfile']['name']
);

// debut validation inscription
 if (!empty($_POST['prenom'])and !empty($_POST['nom'])and !empty($_POST['login'])and !empty($_POST['password']) and !empty($_POST['confirm_password'])) 
        {     
          $pwd1=$_POST['password'];
          $pwd2=$_POST['confirm_password'];
              
              $loginexist =ChercheLogin($_POST['login'],'../json/joueurs.json');
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
                            $s_fileData = file_get_contents('../json/joueurs.json');
                             
                            if( !$s_fileData || strlen($s_fileData) == 0 ) {
                                // On crée le tableau JSON
                                $tableau_pour_json = array();
                            } else {
                                // On récupère le JSON dans un tableau PHP
                                $tableau_pour_json = json_decode($s_fileData, true);
                            }
                             
                            // On ajoute le nouvel élement
                            array_push( $tableau_pour_json,$tableaujoueurs);
                            // On réencode en JSON
                            $contenu_json = json_encode($tableau_pour_json);
                             
                            // On stocke tout le JSON
                            file_put_contents('../json/joueurs.json', $contenu_json);

                         
                      
                        }
                        catch( Exception $e ) {
                            echo "Erreur : ".$e->getMessage();
                        }
                      // fin d'enregistrement 
                          echo '<script type="text/javascript">alert("inscription ruissie ");</script>';
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

// fin validation inscription    

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

</body>
</html>