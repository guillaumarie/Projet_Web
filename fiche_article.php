<!DOCTYPE html>
<html>


<?php include 'includes/head.php'; ?>


<body>
    <?php include 'includes/header.php';

    include 'includes/bdd.php';

    $idAcheteur = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
    $job = isset($_SESSION["job"]) ? $_SESSION["job"] : "";
    $idItem = isset($_GET['id']) ? $_GET['id'] : "";

    $date = date("Y-m-d");

    if ($db_found) {
        $sql = "SELECT * FROM item WHERE IdItem LIKE '$idItem'";
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);
    ?>

        <div class="container-fluid text-center">
            <div class="row content">
                <div class="col-sm-2 sidenav">
                    <h3>Catégorie</h3>
                    <br>
                    <p><?php echo $data['Nom']; ?></p>
                </div>
                <div class="col-sm-8 text-left">
                    <h1 align="center"><?php echo $data['Categorie']; ?></h1>
                    <p align="center"><?php $image = $data['Photo1'];
                                        echo "<img src='$image' style='max-height:300px'>"; ?></p <div class="row">

                    <!--<div class="col-lg-4 col-md-5 col-sm-12"> -->
                    </div>


                    <div id="Affaire2" style="position:absolute; right:6%; bottom:-3%" class="carousel slide col-md-3" data-ride="carousel">



                        <div class="carousel-inner">
                            <div class="carousel-item active">

                                <?php $image1 = $data['Photo1'];
                                echo "<img src='$image1' style='max-height:200px'>"; ?>
                            </div>
                            <div class="carousel-item">

                                <?php $image2 = $data['Photo2'];
                                echo "<img src='$image2' style='max-height:200px'>"; ?>
                            </div>
                                <div class="carousel-item">

                                    <?php $image3 = $data['Photo3'];
                                    echo "<img src='$image3' style='max-height:200px'>"; ?>
                                </div>
                                <div class="carousel-item">

                                    <?php $image4 = $data['Photo4'];
                                    echo "<img src='$image4' style='max-height:200px'>"; ?>
                                </div>
                                <div class="carousel-item">

                                    <?php $image5 = $data['Photo5'];
                                    echo "<img src='$image5' style='max-height:200px'>"; ?>
                                </div>
                            </div>
                            <a class="carousel-control-prev"  <a href="#Affaire2" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#Affaire2" role="button" data-slide="next">
                                <span class="carousel-control-next-icon"  aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                <br><br><br>
                <div>
                    <h3>Description</h3>
                    <p><?php echo $data['Description']; ?></p>
                </div>
                <div class="col-sm-2 sidenav">
                    <div class="well">
                        <h3><?php echo $data['TypeAchat']; ?></h3>
                    </div>
                    <?php
                    if ($job === "acheteur") {
                        // Achat immédiat
                        if ($data["TypeAchat"] == 'immediat') {
                            $sqlImmediat = "SELECT IdAcheteur FROM panier WHERE IdItem LIKE '$idItem' AND IdAcheteur LIKE '$idAcheteur'";
                            $resultImmediat = mysqli_query($db_handle, $sqlImmediat);
                            if (mysqli_num_rows($resultImmediat) !== 0) {  // Si l'acheteur a déjà mis ce produit au panier
                    ?>
                                <div class="well">
                                    <p><?php echo "Vous avez déjà ajouté cet article à votre panier.<br>"; ?></p>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="well">
                                    <p><?php $prix = number_format($data['Prix'], 2, ',', ' ');
                                        echo "Prix : " . $prix . " €<br>"; ?></p>
                                </div>
                                <form action="ajout_item_acheteur.php" method="post">
                                    <div class="well">
                                        <p><?php echo "<input type='hidden' name='idItem' value='$idItem'>";
                                            echo "<input type='hidden' name='idAcheteur' value='$idAcheteur'>" ?></p>
                                    </div>
                                    <div>
                                        <p><input type="submit" name="button1" value="Ajouter au panier"></p>
                                    </div>
                                </form>
                            <?php
                            }
                        }
                        // Achat immédiat ou meilleure offre
                        if ($data["TypeAchat"] == 'immediat_offre') {
                            $sqlOffre = "SELECT IdAcheteur FROM offre WHERE IdItem LIKE '$idItem' AND IdAcheteur LIKE '$idAcheteur'";
                            $resultOffre = mysqli_query($db_handle, $sqlOffre);
                            $sqlImmediat = "SELECT IdAcheteur FROM panier WHERE IdItem LIKE '$idItem' AND IdAcheteur LIKE '$idAcheteur'";
                            $resultImmediat = mysqli_query($db_handle, $sqlImmediat);
                            // Si l'acheteur a déjà commencé les négociations pour ce produit et l'a également ajouté à son panier
                            if (mysqli_num_rows($resultOffre) !== 0 && mysqli_num_rows($resultImmediat) !== 0) {
                            ?>
                                <div class="well">
                                    <p><?php echo "Vous avez déjà ajouté cet article à votre panier.<br>"; ?></p>
                                    <p><?php echo "Vous avez également commencé des négociations pour cet article.<br>
                            Vous pouvez consulter leur avancement dans la rubrique 'Mes offres'"; ?></p>
                                </div>
                            <?php
                            }
                            // Si l'acheteur a déjà commencé les négociations pour ce produit mais ne l'a pas ajouté à son panier
                            elseif (mysqli_num_rows($resultOffre) !== 0 && mysqli_num_rows($resultImmediat) === 0) {
                            ?>
                                <div class="well">
                                    <p><?php $prix = number_format($data['Prix'], 2, ',', ' ');
                                        echo "Prix : " . $prix . " €<br>"; ?></p>
                                </div>
                                <form action="ajout_item_acheteur.php" method="post">
                                    <div class="well">
                                        <p><?php echo "<input type='hidden' name='idItem' value='$idItem'>";
                                            echo "<input type='hidden' name='idAcheteur' value='$idAcheteur'>" ?></p>
                                    </div>
                                    <div>
                                        <p><input type="submit" name="button1" value="Ajouter au panier"></p>
                                    </div>
                                </form>
                                <div class="well">
                                    <p><?php echo "Vous avez déjà commencé des négociations pour cet article.<br>
                            Vous pouvez consulter leur avancement dans la rubrique 'Mes offres'"; ?></p>
                                </div>
                            <?php
                            }
                            // Si l'acheteur n'a pas encore commencé les négociations pour ce produit mais l'a déjà ajouté à son panier
                            elseif (mysqli_num_rows($resultOffre) === 0 && mysqli_num_rows($resultImmediat) !== 0) {
                            ?>
                                <div class="well">
                                    <p><?php $prix = number_format($data['Prix'], 2, ',', ' ');
                                        echo "Prix : " . $prix . " €<br>"; ?></p>
                                </div>
                                <form action="ajout_item_acheteur.php" method="post">
                                    <div class="well">
                                        <p><input class="container-fluid mb-1" type="number" name="prix" placeholder="Vous pouvez proposer un nouveau prix..." size="18"></p>
                                        <p><?php echo "<input type='hidden' name='idItem' value='$idItem'>";
                                            echo "<input type='hidden' name='idAcheteur' value='$idAcheteur'>" ?></p>
                                    </div>
                                    <div>
                                        <p><input type="submit" name="button2" value="Soumettre une offre"></p>
                                    </div>
                                </form>
                                <div class="well">
                                    <p><?php echo "Vous avez déjà ajouté cet article à votre panier.<br>"; ?></p>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="well">
                                    <p><?php $prix = number_format($data['Prix'], 2, ',', ' ');
                                        echo "Prix initial : " . $prix . " €<br>"; ?></p>
                                </div>
                                <form action="ajout_item_acheteur.php" method="post">
                                    <div class="well">
                                        <p><input class="container-fluid mb-1" type="number" name="prix" placeholder="Vous pouvez proposer un nouveau prix..." size="18"></p>
                                        <p><?php echo "<input type='hidden' name='idItem' value='$idItem'>";
                                            echo "<input type='hidden' name='idAcheteur' value='$idAcheteur'>" ?></p>
                                    </div>
                                    <div>
                                        <p><input type="submit" name="button1" value="Ajouter au panier"></p>
                                        <p><input type="submit" name="button2" value="Soumettre une offre"></p>
                                    </div>
                                </form>
                            <?php
                            }
                        }
                        // Meilleure offre
                        if ($data["TypeAchat"] == 'offre') {
                            $sqlOffre = "SELECT IdAcheteur FROM offre WHERE IdItem LIKE '$idItem' AND IdAcheteur LIKE '$idAcheteur'";
                            $resultOffre = mysqli_query($db_handle, $sqlOffre);
                            if (mysqli_num_rows($resultOffre) !== 0) {  // Si l'acheteur a déjà commencé les négociations pour ce produit
                            ?>
                                <div class="well">
                                    <p><?php echo "Vous avez déjà commencé des négociations pour cet article.<br>
                            Vous pouvez consulter leur avancement dans la rubrique 'Mes offres'"; ?></p>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="well">
                                    <p><?php $prix = number_format($data['Prix'], 2, ',', ' ');
                                        echo "Prix initial : " . $prix . " €<br>"; ?></p>
                                </div>
                                <form action="ajout_item_acheteur.php" method="post">
                                    <div class="well">
                                        <p><?php echo "<input class='container-fluid mb-1' type='number' name='prix'
                                        placeholder='Indiquez votre plafond pour cette enchère...' size='18' min='$prix' step='0.01'>"; ?></p>
                                        <p><?php echo "<input type='hidden' name='idItem' value='$idItem'>";
                                        echo "<input type='hidden' name='idAcheteur' value='$idAcheteur'>"; ?></p>
                                    </div>
                                    <div>
                                        <p><input type="submit" name="button2" value="Soumettre une offre"></p>
                                    </div>
                                </form>
                            <?php
                            }
                        }
                        // Enchère
                        if ($data["TypeAchat"] == 'enchere') {
                            $sqlVerif = "SELECT IdAcheteur FROM enchere WHERE IdItem LIKE '$idItem' AND IdAcheteur LIKE '$idAcheteur'";
                            $resultVerif = mysqli_query($db_handle, $sqlVerif);
                            if (mysqli_num_rows($resultVerif) !== 0) {  // Si l'acheteur a déjà proposé une enchère pour ce produit
                            ?>
                                <div class="well">
                                    <p><?php echo "Vous avez déjà proposé un plafond pour cette enchère.<br>
                            Vous pouvez consulter son avancement dans la rubrique 'Mes enchères'"; ?></p>
                                </div>
                                <?php
                            } else {
                                $sqlDates = "SELECT DISTINCT Debut, Fin FROM enchere WHERE IdItem LIKE '$idItem'";
                                $resultDates = mysqli_query($db_handle, $sqlDates);
                                while ($Dates = mysqli_fetch_assoc($resultDates)) {
                                    if ($Dates["Debut"] > $date) {
                                ?>
                                        <div class="well">
                                            <p><?php $debut = $Dates["Debut"];
                                                list($a, $m, $j) = explode("-", $debut);
                                                if ($m == "01") {
                                                    $mois = "janvier";
                                                }
                                                if ($m == "02") {
                                                    $mois = "février";
                                                }
                                                if ($m == "03") {
                                                    $mois = "mars";
                                                }
                                                if ($m == "04") {
                                                    $mois = "avril";
                                                }
                                                if ($m == "05") {
                                                    $mois = "mai";
                                                }
                                                if ($m == "06") {
                                                    $mois = "juin";
                                                }
                                                if ($m == "07") {
                                                    $mois = "juillet";
                                                }
                                                if ($m == "08") {
                                                    $mois = "août";
                                                }
                                                if ($m == "09") {
                                                    $mois = "septembre";
                                                }
                                                if ($m == "10") {
                                                    $mois = "octobre";
                                                }
                                                if ($m == "11") {
                                                    $mois = "novembre";
                                                }
                                                if ($m == "12") {
                                                    $mois = "décembre";
                                                }
                                                echo "Les enchères ne sont pas encore ouvertes pour cet article.<br>
                                    Date d'ouverture : " . $j . " " . $mois . " " . $a . "<br>";
                                                ?></p>
                                        </div>
                                    <?php
                                    }
                                    if ($Dates["Fin"] < $date) {
                                    ?>
                                        <div class="well">
                                            <p><?php echo "Les enchères sont fermées pour cet article.<br>"; ?></p>
                                        </div>
                                    <?php
                                    }
                                    if ($Dates["Debut"] <= $date && $Dates["Fin"] >= $date) {
                                        $sqlEnchere = "SELECT Plafond FROM enchere WHERE IdItem LIKE '$idItem' AND IdAcheteur LIKE '0'";
                                        $resultEnchere = mysqli_query($db_handle, $sqlEnchere);
                                        $Enchere = mysqli_fetch_assoc($resultEnchere);
                                    ?>
                                        <div class="well">
                                            <p><?php $prix = number_format($Enchere['Plafond'], 2, ',', ' ');
                                                echo "Prix actuel : " . $prix . " €<br>"; ?></p>
                                        </div>
                                        <form action="ajout_item_acheteur.php" method="post">
                                            <div class="well">
                                                <p><input class="container-fluid mb-1" type="number" name="prix" placeholder="Indiquez votre plafond pour cette enchère..." size="18"></p>
                                                <p><?php echo "<input type='hidden' name='idItem' value='$idItem'>";
                                                    echo "<input type='hidden' name='idAcheteur' value='$idAcheteur'>" ?></p>
                                            </div>
                                            <div>
                                                <p><input type="submit" name="button3" value="Enchérir"></p>
                                            </div>
                                        </form>
                        <?php
                                    }
                                }
                            }
                        }
                    } elseif ($job === "vendeur") {
                        ?>
                        <div class="well">
                            <p><?php echo "Vous devez vous connecter en tant que client pour acheter cet article.<br>"; ?></p>
                        </div>
                        <br><br>
                        <?php
                        if ($idAcheteur == 1) { // Si admin
                        ?>
                            <form action="gestion_admin.php" method="post">
                                <div class="well">
                                    <p><?php echo "<input type='hidden' name='idItem' value='$idItem'>";
                                        echo "<input type='submit' name='button1' value='Supprimer cet article'>"; ?></p>
                                </div>
                            </form>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="well">
                            <p><?php echo "Vous devez vous connecter pour acheter cet article.<br>"; ?></p>
                        </div>
                    <?php

                    }
                    ?>
                </div>
            <?php
        } else {
            echo "Database not found.";
        }
            ?>
            </div>
        </div>

        <br></br>
        <?php include 'includes/footer.php'; ?>

</body>

</html>