<?php
// Démarre une session PHP pour gérer les sessions utilisateur
session_start();

// Vérifie si l'e-mail de l'utilisateur est défini dans la session
if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"]; // Récupère l'e-mail de l'utilisateur connecté
} else {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php"); 
    exit(); // Termine l'exécution du script PHP
}

// Lit les données des utilisateurs depuis un fichier JSON
$utilisateursJson = file_get_contents("inscriptionjs.json");
$utilisateurs = json_decode($utilisateursJson, true);

$totalElecteurs = 0; // Initialise le nombre total d'électeurs

$electeurs = "<label for='procuration'> Nombre de procurations pour les électeurs (-1 l'électeur ne vote pas) :</label><br>";
foreach ($utilisateurs["utilisateurs"] as $utilisateur) {
    // Parcourt la liste des utilisateurs pour afficher les options de vote
    if ($utilisateur['email'] !== $_SESSION["email"]) {
        $totalElecteurs++; // Incrémente le nombre total d'électeurs
        $electeurs .= "<div>";
        $electeurs .= "<label for='niv{$utilisateur['email']}'>{$utilisateur['email']}</label>";
        // Crée des boutons radio pour chaque électeur pour choisir le nombre de procurations
        for ($i = 2; $i >= -1; $i--) {
            $checked = ($i == -1) ? "checked" : "";
            $electeurs .= "<input type='radio' id='niv{$utilisateur['email']}' name='electeurs[{$utilisateur['email']}]' value='$i' required onclick='updateTotalElecteurs(this)' $checked> $i ";
        }
        $electeurs .= "</div>";
    }
}

$defaultChoix = "
<input type='text' name='Choix1' placeholder='choix 1' required>
<input type='text' name='Choix2' placeholder='choix 2' required>
";

$addChoix = "<input type='button' value='Ajouter un choix' onclick='ajouterChoix()'>";

$msg = "
<div id='contents'>
    <h2>Votons</h2>
    <h3>Création d'un scrutin !</h3>
    <form id='scrutinForm' method='post' action=''>
        <label for='scrutin'>Entrez les différentes informations de votre scrutin :</label>
        <input type='text' name='email' value='{$_SESSION["email"]}' readonly>
        
        <input type='text' name='nom_scrutin' placeholder='Nom du scrutin' required>
        
        $defaultChoix
        
        <div id='choicesContainer'></div>

        $addChoix

        <label for='deadline'>Date limite :</label>
        <input type='text' name='deadline' id='deadline' placeholder='AAAA-MM-JJ' required>

        $electeurs
        <br>
        <input type='text' id='totalElecteurs' value='Nombre de vote restant à attribuer (au maximum) : $totalElecteurs' readonly>

        <input type='button' value='Enregistrer' onclick='creerjson()'>
    </form>
</div>
";

echo $msg;
?>
