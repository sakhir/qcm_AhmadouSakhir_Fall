<!DOCTYPE html>
<html>
<head>
	<title> Page Authentification</title>
	<link rel="stylesheet" type="text/css" href="../css/connexion.css?v=1">
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
    <h1>Login Form</h1>
     <div class="alert-close"> </div>       
  </div>
  
    <form method="post" id="form-connexion">
      <li>
        <input type="text" class="text" error="error-1" placeholder="Login" name="login" onfocus="this.value = '';" ><a href="#" class=" icon user"></a>
      </li>
        <div class="clear"> </div>
        <div class="error-form" id="error-1"> </div>
      <li>
        <input type="password"  placeholder="Password" error="error-2"  name="mdp" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"> <a href="#" class=" icon lock"></a>
      </li>
      <div class="clear"> </div>
      <div class="error-form" id="error-2"> </div>
      <div class="submit">
        <input type="submit"  name="connexion" value="Connexion">
        <h4><a href="inscription.php">S'inscrire pour jouer ?</a></h4>
              <div class="clear">  </div> 
      </div>
        
    </form>
    </div>

</div>

<script type="text/javascript">
 const inputs=document.getElementsByTagName("input");
  for(input of inputs) { 
   input.addEventListener("keyup",function(e){
     if (e.target.hasAttribute("error")) {
      var  idDivError=e.target.getAttribute("error") ; 
      document.getElementById(idDivError).innerText="";

     }   
  
   })
 }

 document.getElementById("form-connexion").addEventListener("submit",function(e){
  const inputs=document.getElementsByTagName("input");
  var error=false;
  for(input of inputs) {
     if (input.hasAttribute("error")) {
    var idDivError=input.getAttribute("error") ; 
    if (!input.value) {

      document.getElementById(idDivError).innerText="Ce champ est obligatoire";
       error=true;  
       } 
    
    } 
  }

 if (error) {
  e.preventDefault();
  return false; 
 }

}) ;
</script>

<?php  

if (isset($_POST['connexion'])) {
session_start();
  $login=htmlspecialchars($_POST['login']);
  $mdp=$_POST['mdp'];

 $trouveloginadmin=ChercheLogin($login,'../json/admin.json');
 $trouveloginjoueur=ChercheLogin($login,'../json/joueurs.json');


   if (!empty($login) and !empty($mdp)) 
        { 
          // on supprime les espace en fin de chaine 
            $login = rtrim($login);
            // on verifie si l utilisateur existe ou non dans la base (le tableau )
              
              if ($trouveloginadmin==true) 
              {
                $pos=TrouvePositionLogin($login,'../json/admin.json');
                $inp = file_get_contents('../json/admin.json');
                $tab= json_decode($inp,true);
                  $log=$tab[$pos]['login'];
                  $pwd=$tab[$pos]['mdp'];

                    if ($login==$log and $mdp==$pwd)
                     { 
                       $_SESSION['prenom']= $tab[$pos]['prenom'];
                       $_SESSION['nom']= $tab[$pos]['nom'];
                       $_SESSION['avatar']=$tab[$pos]['avatar'];
                       $_SESSION['user']=true;
                       $_SESSION['profil']='admin';
                       header('location:listequestions.php');
              
                     }
                else { 
                      echo '<script type="text/javascript" >alert("donnees incorrectes  ")</script>';
                    }
              
              }
              elseif ($trouveloginjoueur==true) 
              {
                $pos=TrouvePositionLogin($login,'../json/joueurs.json');
                $inp = file_get_contents('../json/joueurs.json');
                $tab= json_decode($inp,true);
                  $log=$tab[$pos]['login'];
                  $pwd=$tab[$pos]['password'];

                    if ($login==$log and $mdp==$pwd)
                     { 
                        $_SESSION['prenom']= $tab[$pos]['prenom'];
                        $_SESSION['nom']   = $tab[$pos]['nom'];
                        $_SESSION['avatar']=$tab[$pos]['avatar'];
                        $_SESSION['user']  =true;
                        $_SESSION['profil']='joueur';
                        header('location:EspaceJoueur.php');
              
                     }
                else { 
                      echo '<script type="text/javascript" >alert("donnees incorrectes  ")</script>';
                    }
              }

              else 
              {
                 echo '<script type="text/javascript" >alert("Veuillez vous inscrire ")</script>';
              } 

          
       
        } // si le pseudo et le mot de passe ne sont pas vides
        else 
        {  
         echo '<script type="text/javascript" >alert("Veuillez renseigner les champs   ")</script>';
        } 

  # code...
}

//Une fonction qui verifie si le pseudo de l'utilisateur existe dans un fichier  json 
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

// fonction  qui trouve la position du login 
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

?>
</body>
</html>

   