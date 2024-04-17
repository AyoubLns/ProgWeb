<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Votons </title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="icon" href="icon.png" type="image/png">
</head>
<body>

<?php
    // Démarre une session PHP pour gérer les sessions utilisateur
    session_start();

    // Initialise un message vide pour afficher les erreurs de connexion
    $msg = "";

    // Vérifie si le formulaire a été soumis et que le bouton de connexion a été cliqué
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        // Récupère les données des utilisateurs à partir du fichier JSON
        $utilisateursJson = file_get_contents("inscriptionjs.json");
        $utilisateurs = json_decode($utilisateursJson, true);

        // Récupère les valeurs de l'e-mail et du mot de passe envoyés par le formulaire
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

        // Initialise un drapeau pour indiquer si l'utilisateur a été trouvé
        $utilisateurTrouve = false;

        // Parcourt la liste des utilisateurs pour vérifier les identifiants
        foreach ($utilisateurs["utilisateurs"] as $utilisateur) {
            if (isset($utilisateur["email"]) && isset($utilisateur["mdp"])) {
                // Vérifie si l'e-mail et le mot de passe correspondent à ceux stockés
                if ($utilisateur["email"] == $email && password_verify($password, $utilisateur["mdp"])) {
                    // Si les identifiants sont corrects, défini la session avec l'e-mail de l'utilisateur
                    $utilisateurTrouve = true;
                    $_SESSION["email"] = $email; 
                    break; // Sort de la boucle dès qu'un utilisateur est trouvé
                }
            }
        }

        // Redirige l'utilisateur vers la page d'accueil s'il est connecté avec succès
        if ($utilisateurTrouve) {
            header("Location: pagedaccueil.php");
            exit();
        } else {
            // Affiche un message d'erreur si les identifiants sont incorrects
            $msg = "<p>Identifiants incorrects. Veuillez réessayer.</p>";
        }
    }
?>

<h2>Connexion</h2>
    
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="email">Veuillez saisir votre email :</label>
    <input type="email" name="email" placeholder="exemple@mail.com" required>
    
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" placeholder="********" required>
    
    <input type="submit" name="login" value="Se connecter">
        
    <span class="singup"> Vous n'avez pas de compte ?
        <a href="inscription.php"> Inscrivez-vous </a>
    </span>

    <?php 
        echo $msg; 
    ?> 
</form>

</body>
</html>
