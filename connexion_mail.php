
<?php
session_start();


$IdAcheteur = $_SESSION["id"];
$NumeroCommande = $_SESSION["item"];


$Nom = "";
$Prenom = "";
$Adresse1 = "";
$Adresse2 = "";
$CP = "";
$Ville = "";
$Pays = "";
$Telephone = "";
$Email = "";
$TypeCarte = "";
$IdItem = "";
$Date = "";
$Prix = 0;
$TypeAchat = "";
$IdVendeur = "";
$Total = 0;
$NombreArticles = 0;

if ($IdAcheteur) {
    include 'includes/bdd.php';

    if ($db_found) {
        $sql = "SELECT * FROM acheteur WHERE IdAcheteur LIKE '$IdAcheteur'";
        $result = mysqli_query($db_handle, $sql);

        if (mysqli_num_rows($result) === 0) {
            echo "Ce compte client n'existe pas.<br>";
        } else {
            $sql .= " AND IdAcheteur LIKE '$IdAcheteur'";
            $result = mysqli_query($db_handle, $sql);

            if (mysqli_num_rows($result) === 0) {
                echo "Votre mot de passe est incorrect.<br>";
            } else {
                while ($data = mysqli_fetch_assoc($result)) {

                    $IdAcheteur = $data['IdAcheteur'];
                    $Nom = $data['Nom'];
                    $Prenom = $data['Prenom'];
                    $Adresse1 = $data['Adresse1'];
                    $Adresse2 = $data['Adresse2'];
                    $CP = $data['CP'];
                    $Ville = $data['Ville'];
                    $Pays = $data['Pays'];
                    $Telephone = $data['Telephone'];
                    $Email = $data['Email'];
                    $TypeCarte = $data['TypeCarte'];
                }
            }
        }
    } else {
        echo "Database not found.<br>";
    }
    mysqli_close($db_handle);
}

if ($NumeroCommande) {
    $database = "ebay_ece";

    $db_handle = mysqli_connect('127.0.0.1:3308', 'root', '');
    $db_found = mysqli_select_db($db_handle, $database);

    if ($db_found) {
        $sql = "SELECT * FROM achat WHERE NumeroCommande LIKE '$NumeroCommande'";
        $result = mysqli_query($db_handle, $sql);

        while ($data = mysqli_fetch_assoc($result)) {
            $RefAchat = $data['RefAchat'];
            $IdItem = $data['IdItem'];
            $IdAcheteur = $data['IdAcheteur'];
            $IdVendeur = $data['IdVendeur'];
            $Date = $data['DateVente'];
            $Prix = $data['Prix'];
            $Total += $Prix;
            $TypeAchat = $data['TypeAchat'];
            $NombreArticles += 1;
        }
    } else {
        echo "Database not found.<br>";
    }
    mysqli_close($db_handle);
}

$header = "MIME-Version: 1.0\r\n";
$header .= 'From:"Ebayece.com"<ebayece2020@gmail.com>' . "\n";
$header .= 'Content-Type:text/html; charset="uft-8"' . "\n";
$header .= 'Content-Transfer-Encoding: 8bit';

$message = 'Bonjour ';
$message .= $Prenom;
$message .= ' ';
$message .= $Nom;
$message .= ',<br><br>Merci d\'avoir fait affaire avec Ebay ECE.';
$message .= '<br><br>';
$message .= 'Nous confirmons le paiement de votre commande (';
$message .= $NumeroCommande;
$message .= ') du ';
$message .= $Date;
$message .= '.';
$message .= '<br><br>';
$message .= 'Votre numéro client : ';
$message .= $IdAcheteur;
$message .= '<br><br>';
$message .= 'Informations sur votre commande : ';
$message .= '<br><br>';
$message .= 'Vous avez commandé ';
$message .= $NombreArticles;
$message .= ' articles.';
$message .= '<br><br>';
$message .= 'Montant total : ';
$message .= $Total;
$message .= ' €';
$message .= '<br><br>';
$message .= 'Mode de paiement choisi : ';
$message .= $TypeCarte;
$message .= '<br><br>';
$message .= 'Adresse de livraison : ';
$message .= '<br>';
$message .= $Prenom;
$message .= ' ';
$message .= $Nom;
$message .= '<br>';
$message .= $Adresse1;
$message .= '<br>';
if ($Adresse2) {
    $message .= $Adresse2;
    $message .= '<br>';
}
$message .= $CP;
$message .= ' ';
$message .= $Ville;
$message .= '<br>';
$message .= $Telephone;
$message .= '<br>';
$message .= $Pays;
$message .= '<br>';
$message .= '<br>';
$message .= 'Pour toute question sur votre commande veuillez contacter notre servive après vente.';
$message .= '<br><br>';
$message .= 'Merci d\'avoir fait confiance à EBAY ECE, nous esperons vous revoir très vite.';
$message .= '<br>';
$message .= 'Recevez nos sincères salutations EBAY ECE, Paris, ebayece2020@gmail.com.';


mail("killian95840@gmail.com", "Confirmation de votre commande chez EBAY ECE", $message, $header);
/*mail($Email, "Confirmation de votre commande chez EBAY ECE", $message, $header);*/

?>

