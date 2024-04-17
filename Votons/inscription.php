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
$msg = "";

// Vérifie si le formulaire a été soumis et que le bouton d'inscription a été cliqué
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Récupère les données du formulaire
    $newEmail = htmlspecialchars($_POST["new_email"]);
    $newPassword = htmlspecialchars($_POST["new_password"]);
    $confPassword = htmlspecialchars($_POST["confirm_password"]);

    // Chemin du fichier JSON contenant les données des utilisateurs
    $fichierJSON = 'inscriptionjs.json';
    $newUtil = json_decode(file_get_contents($fichierJSON), true);

    // Vérifie si l'e-mail est déjà associé à un compte
    if (isset($newUtil['utilisateurs'])) {
        foreach ($newUtil['utilisateurs'] as $email) {
            if ($email['email'] == $newEmail) {
                $msg = "<p>Inscription incorrecte. Cet email est déjà associé à un compte.</p>";
                break;
            }
        }
    }

    // Vérifie si les mots de passe correspondent et effectue l'inscription
    if (empty($msg) && $newPassword == $confPassword) {
        $newUtil['utilisateurs'][] = ['email' => $newEmail, 'mdp' => password_hash($newPassword, PASSWORD_DEFAULT)]; 
        file_put_contents($fichierJSON, json_encode($newUtil, JSON_PRETTY_PRINT));
        $msg = "<p>Inscription réussie. Vous pouvez maintenant vous connecter.</p>";
    } elseif (empty($msg)) {
        $msg = "<p>Inscription incorrecte. Vous n'avez pas entré le même mot de passe.</p>";
    }
}
?>

<div id="contents">
    <h2>Inscription</h2>
    <form method="post" action="">
        <label for="new_email"> Nouvel email :</label>
        <input type="email" name="new_email" placeholder="exemple@mail.com" required>
        <br>
        <label for="new_password"> Nouveau mot de passe :</label>
        <input type="password" name="new_password" placeholder="********" required>
        <br>
        <label for="confirm_password"> Confirmez le nouveau mot de passe :</label>
        <input type="password" name="confirm_password" placeholder="********" required>
        <br>
        <input type="submit" name="register" value="S'inscrire">
        <a href="connexion.php"> Connexion </a>
        <?php 
            echo $msg; 
        ?>
    </form>
</div>
</body>
</html>
