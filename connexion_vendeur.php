<?php

session_start();

    $_SESSION["job"] = 'vendeur';
   
    $email = isset($_POST["email"])? $_POST["email"] : "";
    $password = isset($_POST["password"])? $_POST["password"] : "";

    if($email && $password) {
        include 'includes/bdd.php';

        if ($db_found) {
            $sql = "SELECT * FROM vendeur WHERE Email LIKE '$email'"; 
            $result = mysqli_query($db_handle, $sql);

            if (mysqli_num_rows($result) === 0) {
                echo "Ce compte vendeur n'existe pas.<br>";
            } else {
                $sql .= " AND Password LIKE '$password'";
                $result = mysqli_query($db_handle, $sql);

                if (mysqli_num_rows($result) === 0) {
                    echo "Votre mot de passe est incorrect.<br>";
                } else {
                    $data = mysqli_fetch_assoc($result);
                    $_SESSION["connected"] = 2 ;
                    $_SESSION["prenom"] = $data["Prenom"];
                    $_SESSION["id"] = $data["IdVendeur"];
                    header('Location: accueil.php');
                }
            }
        } else {
            echo "Database not found.<br>";
        }
        mysqli_close($db_handle);
    } else {
        echo "Veuillez remplir tous les champs.<br>";
    }
?>