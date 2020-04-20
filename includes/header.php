<?php 

    session_start();
    $_SESSION["email"] = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
    $_SESSION["job"] = isset($_SESSION["job"]) ? $_SESSION["job"] : "";
    $_SESSION["connected"] = isset($_SESSION["connected"]) ? $_SESSION["connected"] : 1;
    $_SESSION["id"] = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
    
	echo '
        <header><nav class="navbar navbar-expand-md"><a class="navbar-brand" href="accueil.php">
        <img src="images/navbar/logo.png" width="250" height="120"/></a><div class="collapse navbar-collapse" id="main-navigation">
        <ul class="navbar-nav">
        ';
        
         
                  
    if ($_SESSION['connected']==2){if($_SESSION['job']=="vendeur"){
        $connexion = 1;
        echo '<li class="nav-item"><a class="nav-link" href="fiche_vendeur.php">'.$_SESSION["prenom"].'</a></li>';
        echo '
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" id="navbar_Dropdown" role="button" data-toggle="dropdown">
        Ventes
        </a>
         <ul class="dropdown-menu">
         <li><a class="dropdown-item" href="categories.php">Par categories</a></li>
         <li class="dropdown-divider"></li>
         <li><a class="dropdown-item" href="Ventes.php">Par type de ventes</a></li>
         <li class="dropdown-divider"></li>
         <li><a class="dropdown-item" href="toutes_ventes.php">Tous type</a></li>
         <li class="dropdown-divider"></li>
         </ul>
         ';
        echo '<li class="nav-item"><a class="nav-link" href="espace_vendeur.php">Vendre</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="offre.php">Offres en cours</a></li>';
    }


    elseif($_SESSION["job"]=="acheteur"){
       
        echo '<li class="nav-item"><a class="nav-link" href="espace_acheteur.php">'.$_SESSION["prenom"].'</a></li>';
        echo '
       
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color:white" id="navbar_Dropdown" role="button" data-toggle="dropdown">
        Ventes
        </a>
         <ul class="dropdown-menu">
         <li><a class="dropdown-item" href="categories.php">Par categories</a></li>
         <li class="dropdown-divider"></li>
         <li><a class="dropdown-item" href="Ventes.php">Par type de ventes</a></li>
         <li class="dropdown-divider"></li>
         <li><a class="dropdown-item" href="toutes_ventes.php">Tous type</a></li>
         <li class="dropdown-divider"></li>
         </ul>
         ';
         echo '<li class="nav-item"><a class="nav-link" href="offre.php">Offres en cours</a></li>';

    }
}
    else {
        $connexion = 0;
        echo '<li class="nav-item"><a class="nav-link" href="acces_vendeur.php">Connexion</a></li>
              <li class="nav-item"><a class="nav-link" href="acces_acheteur.php"> Déjà membre ?</a></li>';
    }

   
        
    if ($_SESSION['connected']==2) {
        $connexion = 1;
        echo '<li class="nav-item"><a class="nav-link" href="Deconnexion.php">Deconnexion</a></li>';
        }
        else {
            $connexion = 0;
        }

    echo'
        <li class="nav-item"><a class="nav-link" href="panier.php"><img src="images/navbar/logo_panier.jpg" width="30" height="30"/>
        </a></li></ul></div></nav><br></br></header>
        ';
?>