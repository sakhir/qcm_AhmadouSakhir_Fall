 <?php 
      $selected='selected="selected"';
      (isset($_POST['liste'])) ? $liste=$_POST['liste'] : $liste="";
     ?>

  <div class="droite">
     <div class="droite-content">
       <h2>PARAMETRER VOTRE QUESTION   </h2> 
       <div id="bleu">
         <form method="post" name="formulaireDynamique">
                  <label for="questions" style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Questions  </label>
                  <input type="textarea" id="qu" name="question" required="" aria-required="true" value="<?php if (isset($_POST['liste'])) echo htmlentities($_POST['question']) ?>" style="width: 70%; height: 90px;margin-left: 5%;margin-top: 5%; border-radius: 5px;background-color:#F4F4F4; "> <br><br>

                   <label for="score"  style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Nbre de Points</label>
                  <input type="number" id="sc" name="score" required="" aria-required="true" value="<?php if (isset($_POST['liste'])) echo htmlentities($_POST['score']) ?>" min="1" style="width: 10%; height:30px;margin-left: 2%;margin-top: 5%;background-color:#F4F4F4;border:1px;border-style:solid;border-color:  #51BFD0 ;" > <br><br>

                  <label for="score" style="font-size: 21px;font-weight: bold;margin-top: 2%;margin-left: 2%;">Type de reponse  </label>
                     <select name="liste" onchange="submit();" style="width: 60%; height:35px;margin-left: 2%%;margin-top: 5%;background-color:#F4F4F4;">
                      <option>Donnez le type de reponse </option>
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

                      <input type="submit" name="valider" value="Enregistrer" style="" class="enr">

          </form>
       </div>
     </div>
  </div>