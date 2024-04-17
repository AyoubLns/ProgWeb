<?php
session_start();

    // Vérifie si la méthode de la requête est POST et si le paramètre scrutinId est défini
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["scrutinId"])) {
        $scrutinsJson = file_get_contents("scrutinjs.json");
        $scrutins = json_decode($scrutinsJson, true);

        // Récupère l'identifiant du scrutin à supprimer à partir des données POST
        $scrutinId = $_POST["scrutinId"];

        // Parcourt les scrutins pour trouver celui correspondant à l'identifiant fourni
        foreach ($scrutins["scrutins"] as $key => $scrutin) {
            // Vérifie si le nom du scrutin correspond à celui à supprimer
            if ($scrutin["nom_scrutin"] == $scrutinId) {
                // Utilise unset() pour supprimer l'élément du tableau des scrutins
                unset($scrutins["scrutins"][$key]);
                break; // Sort de la boucle une fois que le scrutin est trouvé et supprimé
            }
        }

        // Réindexe le tableau après suppression pour éviter les clés numériques non consécutives
        $scrutins["scrutins"] = array_values($scrutins["scrutins"]);

        // Enregistre les modifications dans le fichier JSON
        file_put_contents("scrutinjs.json", json_encode($scrutins, JSON_PRETTY_PRINT));

        // Renvoie une réponse JSON indiquant le succès de l'opération
        echo json_encode(array("success" => true));
        exit();
    }
?>
