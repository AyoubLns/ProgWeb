<?php
// Démarre une session PHP pour gérer les sessions utilisateur
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votons</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" href="icon.png" type="image/png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
    <script src="script.js"></script> 
</head>
<body>
    <div id="contents">
        <h2>Votons</h2>
        <h3>Bienvenue sur notre site de vote !</h3>

        <form method="post" action="">
            <label for="scrutin">Que souhaitez-vous faire ?</label>

            <input type="button" value="Créer un scrutin" onclick='creer()'>
            <input type="button" value="Participer à un scrutin" onclick='participer()'>
            <input type="button" value="Consulter les résultats des scrutins" onclick='resultat()'>
            <input type="button" value="Modifier ces scrutins" onclick='modifier()'>
        
            <?php
                // Vérifie si l'utilisateur est connecté
                if(isset($_SESSION['email'])) {
                    // Affiche le bouton de déconnexion si l'utilisateur est connecté
                    echo '<input type="submit" class="submit" name="logout" value="Déconnexion">';
                } else {
                    // Affiche le bouton de connexion si l'utilisateur n'est pas connecté
                    echo '<input type="submit" class="submit" name="login" value="Connexion">';
                }
            ?>
        </form>
    </div>

    <?php
        // Traitement du formulaire de déconnexion
        if(isset($_POST['logout'])) {
            // Détruit la session pour déconnecter l'utilisateur
            session_destroy();
            // Redirige vers la page d'accueil
            header("Location: pagedaccueil.php");
        }
        // Traitement du formulaire de connexion
        if(isset($_POST['login'])) {
            // Redirige vers la page de connexion
            header("Location: connexion.php"); 
            exit(); 
        }
    ?>
</body>
</html>
