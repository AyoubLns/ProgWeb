<?php
// Démarre une session PHP pour gérer les sessions utilisateur
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"]; // Récupère l'e-mail de l'utilisateur connecté
} else {
    header("Location: connexion.php"); 
    exit(); // Termine l'exécution du script PHP
}

// Lit les données des scrutins depuis un fichier JSON
$scrutinsJson = file_get_contents("scrutinjs.json");
$scrutins = json_decode($scrutinsJson, true);

// Initialise une chaîne pour stocker les boîtes de scrutin HTML
$scrutinBoxes = '';

// Parcourt la liste des scrutins pour afficher ceux dans lesquels l'utilisateur peut participer
foreach ($scrutins["scrutins"] as $scrutin) {
    $scrutinCreator = $scrutin["email"]; // Récupère l'e-mail du créateur du scrutin
    $scrutinName = $scrutin["nom_scrutin"]; // Récupère le nom du scrutin

    $scrutinDate = strtotime($scrutin["deadline"]); // Convertit la date limite du scrutin en timestamp
    $currentDate = time(); // Récupère le timestamp actuel

    // Vérifie si la date limite du scrutin est dépassée, sinon passe au scrutin suivant
    if ($scrutinDate <= $currentDate) {
        continue;
    }

    // Vérifie si l'utilisateur a des procurations restantes pour ce scrutin
    if (isset($scrutin["electeurs"][$email]) && $scrutin["electeurs"][$email]["nbrProc"] > -1) {
        $nbrprocuration = $scrutin["electeurs"][$email]["nbrProc"];
        if(is_array($nbrprocuration)) {
            $nbrprocuration = implode(" ", $nbrprocuration);
        }

        // Construit la boîte de scrutin HTML
        $scrutinBoxes .= "
            <div class='scrutin-box'>
                <p>Créé par : $scrutinCreator</p>
                <p>Nom du scrutin : $scrutinName</p>
                <p>Nombre de procuration(s) restante(s) : $nbrprocuration</p>
                <label for='choix'>Choisissez un choix:</label>
                <select name='choix' id='choix_$scrutinName'>";

        // Ajoute les options de choix au menu déroulant
        foreach ($scrutin['choix'] as $choix) {
            $scrutinBoxes .= "<option value='$choix'>$choix</option>";
        }

        // Ajoute un bouton pour voter dans la boîte de scrutin
        $scrutinBoxes .= "
                </select>
                <input type='button' class='vote-btn' value='Voter' data-scrutin='$scrutinName' onclick='participervote(\"$scrutinName\")'>
            </div>
        ";
    }
}

// Construit le contenu HTML pour la page de participation aux scrutins
$msg = "
    <div id='contentsparticiper'>
        <h2> Votons </h2>
        <h3> Participation à un scrutin ! </h3>
        <form method='post' action=''>
            <label for='scrutin'> Veuillez participer à un vote </label>
            <div id='scrutinList'>$scrutinBoxes</div>
        </form>
    </div> 
";

echo $msg; 
?>
