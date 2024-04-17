<?php
// Démarre une session PHP pour gérer les sessions utilisateur
session_start();

// Vérifie si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les données envoyées par le formulaire
    $email = $_POST["email"];
    $nom_scrutin = $_POST["nom_scrutin"];
    $deadline = $_POST["deadline"];
    $electeurs = $_POST["electeurs"];

    // Calcule le nombre total d'électeurs et de procurations
    $totalElecteurs = count($electeurs);
    $totalProcurations = 0;

    // Boucle à travers les électeurs pour calculer le total des procurations
    foreach ($electeurs as $email => $procurations) {
        $totalProcurations += intval($procurations) + 1;
    }

    // Initialise un tableau pour stocker les choix des scrutins
    $choix = array();
    for ($i = 1; $i <= 5; $i++) {
        if (isset($_POST["Choix$i"]) && !empty($_POST["Choix$i"])) {
            $choix[] = $_POST["Choix$i"];
        }
    }

    // Vérifie si le nombre total de procurations est inférieur ou égal au nombre total d'électeurs
    if ($totalProcurations > $totalElecteurs) {
        echo json_encode(array("success" => false, "message" => "Le nombre de procurations doit être inférieur ou égal au nombre total d'électeurs."));
        exit(); // Termine l'exécution du script PHP
    }

    // Lit les données des scrutins depuis un fichier JSON
    $scrutinJson = file_get_contents("scrutinjs.json");
    $scrutinData = json_decode($scrutinJson, true);

    // Crée un nouveau scrutin avec les données reçues
    $newScrutin = array(
        "email" => $email,
        "nom_scrutin" => $nom_scrutin,
        "choix" => $choix,
        "deadline" => $deadline,
        "electeurs" => array()
    );

    // Ajoute les électeurs et leurs procurations au nouveau scrutin
    foreach ($electeurs as $email => $procurations) {
        $newScrutin["electeurs"][$email] = array("nbrProcurations" => intval($procurations), "aVote" => false);
    }

    // Ajoute le nouveau scrutin aux données des scrutins
    $scrutinData["scrutins"][] = $newScrutin;

    if (file_put_contents("scrutinjs.json", json_encode($scrutinData, JSON_PRETTY_PRINT))) {
        echo json_encode(array("success" => true)); 
    } else {
        echo json_encode(array("success" => false, "message" => "Erreur lors de l'enregistrement des données.")); // Indique une erreur en cas d'échec
    }
} else {
    echo json_encode(array("success" => false, "message" => "Requête invalide.")); // Indique une requête invalide si la méthode n'est pas POST
}
?>
