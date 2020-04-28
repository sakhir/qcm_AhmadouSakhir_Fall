 <div class="droite">
     <div class="form-v2-content">
      <form class="form-detail" action="#" method="post" id="myform"  enctype="multipart/form-data">
        <h2>S'inscrire</h2>
        <label>Pour tester votre niveau de culture generale</label>
        <div class="form-row">
          <label for="full-name">Prenom</label>
          <input type="text" name="prenom" id="" required="" aria-required="true" class="input-text" placeholder="Prenom" value="<?php if (isset($_POST['prenom']) ) echo htmlentities($_POST['prenom']) ?>">
        </div>
        <div class="form-row">
          <label for="full-name">Nom</label>
          <input type="text" name="nom" id="" required="" aria-required="true" class="input-text" placeholder="Nom" value="<?php if (isset($_POST['nom']) ) echo htmlentities($_POST['nom']) ?>">
        </div>
         <div class="form-row">
          <label for="full-login">Login</label>
          <input type="text" name="login" id="" required="" aria-required="true" class="input-text" placeholder="Login" value="<?php if (isset($_POST['login']) ) echo htmlentities($_POST['login']) ?>">
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
         <input type="file"  name="avatarfile" value="Choisir un fichier" id="avatar"  onchange="handleFiles(files)" > 
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
  </div>