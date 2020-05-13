 <div class="gauche">
      <div class="degrade"> <img class="profiler" style=" height: 15%;" src="../images/avatar/<?php if (isset($_SESSION['avatar'])) {echo $_SESSION['avatar'];} ?>">
    <span id="pnom"><?php if (isset($_SESSION['nom']) and isset($_SESSION['prenom']) )
    {
    echo $_SESSION['prenom'].' '.$_SESSION['nom'] ; }?></span> </div>
      <div class="menu">
         <div id="sidebar">

                <ul>
                  
          <?php 
                  if ($nav_en_cours =="presentation")
                {
                echo '<li class="active">';
                }
                else
                {
                echo '<li>';
                }
                ?>
                        <a href="listequestions.php">Liste Questions<img src="../images/Icones/ic-liste.png"> </a>
                     </li>
          <?php 

                                 if ($nav_en_cours =="creercompte")
              {
              echo '<li class="active">';
              }
              else
              {
              echo '<li>';
              }
              ?> 
                        <a href="creationcompte.php">Creer Admin<img src="../images/Icones/ic-ajout-active.png"> </a>
                        
                    </li>
         <?php       
        if ($nav_en_cours =="listejoueur")
            {
            echo '<li class="active">';
            }
            else
            {
            echo '<li>';
            }
            ?> 
                   <a href="listejoueurs.php">Liste Joueurs <img src="../images/Icones/ic-liste.png"> </a>
                    </li>
          <?php       
           if ($nav_en_cours =="creerquestion")
                    {
                    echo '<li class="active">';
                    }
                    else
                    {
                    echo '<li>';
                    }
                    ?> 
                        <a href="creerquestion.php">Creer Questions<img src="../images/Icones/ic-ajout.png"> </a>
                    </li>
                </ul>

                
            </div>
      </div>
  </div>