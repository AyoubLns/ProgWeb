<?php
session_start();

// Vérifie si la méthode de requête est POST et si les paramètres "scrutin" et "choix" ont été envoyés
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["scrutin"]) && isset($_POST["choix"])) {
    $scrutinName = $_POST["scrutin"]; // Récupère le nom du scrutin à partir des données POST
    $choix = $_POST["choix"]; // Récupère le choix de l'utilisateur à partir des données POST

    // Charge les données des scrutins à partir du fichier JSON
    $scrutinsJson = file_get_contents("scrutinjs.json");
    $scrutins = json_decode($scrutinsJson, true);

    // Parcourt la liste des scrutins pour trouver celui correspondant au nom reçu du formulaire
    foreach ($scrutins["scrutins"] as $key => $scrutin) {
        if ($scrutin["nom_scrutin"] == $scrutinName) {
            // Vérifie si l'utilisateur a le droit de voter dans ce scrutin
            if (isset($scrutin["electeurs"][$_SESSION["email"]]) && $scrutin["electeurs"][$_SESSION["email"]] > -1) {
                // Incrémente le compteur de votes pour le choix sélectionné
                $scrutins["scrutins"][$key]["votes"][$choix]++;

                // Décrémente le nombre de procurations de l'utilisateur
                $scrutins["scrutins"][$key]["electeurs"][$_SESSION["email"]]["nbrProc"] = strval($scrutins["scrutins"][$key]["electeurs"][$_SESSION["email"]]["nbrProc"] - 1);

                // Marque l'utilisateur comme ayant voté dans ce scrutin
                if (!$scrutins["scrutins"][$key]["electeurs"][$_SESSION["email"]]["aVote"]) {
                    $scrutins["scrutins"][$key]["electeurs"][$_SESSION["email"]]["aVote"] = true;
                }

                // Enregistre les modifications dans le fichier JSON
                file_put_contents("scrutinjs.json", json_encode($scrutins, JSON_PRETTY_PRINT));

                // Renvoie une réponse JSON indiquant le succès de l'opération
                echo json_encode(array("success" => true));
                exit();
            }
        }
    }
}
?>
