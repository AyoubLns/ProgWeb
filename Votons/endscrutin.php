<?php
session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["scrutinId"])) {
        // Assurez-vous que le scrutinId est correctement récupéré
        $scrutinId = $_POST["scrutinId"];

        // Charger les scrutins depuis le fichier JSON
        $scrutinsJson = file_get_contents("scrutinjs.json");
        $scrutins = json_decode($scrutinsJson, true);

        // Parcourir les scrutins pour trouver celui correspondant à l'ID
        foreach ($scrutins["scrutins"] as $key => $scrutin) {
            if ($scrutin["nom_scrutin"] == $scrutinId) {
                // Mettre à jour la date de fin du scrutin
                $scrutins["scrutins"][$key]["deadline"] = date("Y-m-d");
                break;
            }
        }

        // Enregistrer les modifications dans le fichier JSON
        file_put_contents("scrutinjs.json", json_encode($scrutins, JSON_PRETTY_PRINT));
        
        // Renvoie une réponse JSON indiquant le succès de l'opération
        echo json_encode(array("success" => true));
        exit();
    }
?>
