<?php
session_start();

// Vérifie si l'utilisateur est connecté
if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
} else {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php"); 
    exit(); 
}

// Charge les données des scrutins à partir du fichier JSON
$scrutinsJson = file_get_contents("scrutinjs.json");
$scrutins = json_decode($scrutinsJson, true);

// Initialise une chaîne vide pour stocker les résultats des scrutins
$scrutinResults = '';

// Parcourt la liste des scrutins pour afficher les résultats
foreach ($scrutins["scrutins"] as $scrutin) {
    // Récupère les détails du scrutin
    $scrutinCreator = $scrutin["email"];
    $scrutinName = $scrutin["nom_scrutin"];

    // Vérifie si l'utilisateur est le créateur du scrutin
    if ($scrutinCreator == $email) {
        $creatorLabel = "Créé par : Vous";
    } else {
        $creatorLabel = "Créé par : $scrutinCreator";
    }

    // Vérifie l'état du scrutin en fonction de la date limite
    $scrutinDate = strtotime($scrutin["deadline"]);
    $currentDate = time(); 

    // Si la date limite est dépassée et l'utilisateur n'est pas le créateur du scrutin, passe au scrutin suivant
    if ($scrutinDate > $currentDate && $scrutinCreator != $email) {
        continue;
    }

    // Calcule le temps restant avant la fin du scrutin
    $remainingTime = $scrutinDate - $currentDate;
    if ($remainingTime <= 0) {
        // Si le scrutin est terminé, affiche la date de fin
        $timeStatus = "Fini depuis : " . date("Y-m-d", $scrutinDate);
    } else {
        // Si le scrutin est en cours, affiche le temps restant sous forme d'années, de mois, de jours, d'heures ou de minutes
        $interval = date_diff(date_create(), date_create(date("Y-m-d", $scrutinDate)));
        $years = $interval->format('%y');
        $months = $interval->format('%m');
        $days = $interval->format('%d');
        $hours = $interval->format('%h');
        $minutes = $interval->format('%i');

        if ($years > 0) {
            $timeStatus = "$years année(s)";
        } elseif ($months > 0) {
            $timeStatus = "$months mois";
        } elseif ($days > 0) {
            $timeStatus = "$days jour(s)";
        } elseif ($hours > 0) {
            $timeStatus = "$hours heure(s)";
        } else {
            $timeStatus = "$minutes minute(s)";
        }
    }

    // Calcule les résultats du scrutin sous forme de pourcentages pour chaque choix
    $totalVotes = array_sum($scrutin["votes"]);
    $results = [];
    foreach ($scrutin["votes"] as $choix => $votes) {
        $percentage = ($totalVotes > 0) ? round(($votes / $totalVotes) * 100) : 0;
        $results[$choix] = $percentage . "%";
    }

    // Génère les barres de progression pour afficher les résultats
    $progressBars = '';
    $maxPercentage = max($results);
    foreach ($results as $choix => $percentage) {
        if ($percentage == $maxPercentage) {
            $color = '#3c7922'; // Couleur verte pour le choix le plus populaire
        } elseif ($remainingTime <= 0) {
            $color = '#B10000'; // Couleur rouge pour les scrutins terminés
        } else {
            $color = '#ff6a33'; // Couleur orange pour les scrutins en cours
        }

        // Ajoute une barre de progression pour chaque choix
        $progressBars .= "<div class='progress-bar' style='width: $percentage%; background-color: $color;'> $choix : $percentage </div>";
    }

    // Construit le bloc HTML pour afficher les résultats du scrutin
    $scrutinResults .= "
        <div class='scrutin-result'>
            <p>Résultats du scrutin : $scrutinName</p>
            <p> $creatorLabel </p>
        ";

    // Affiche le statut de la date limite du scrutin
    if ($remainingTime <= 0) {
        $scrutinResults .= "<p>$timeStatus</p>";
    } else {
        $scrutinResults .= "<p>Fin du vote dans : $timeStatus</p>";
    }

    // Ajoute les barres de progression pour afficher les résultats
    $scrutinResults .= "
            <p>Résultats :</p>
            $progressBars
            </div>
        ";
}

// Construit le contenu HTML final à afficher
$msg = "
    <div id='contentsresultat'>
        <h2> Votons </h2>
        <h3> Résultat des scrutins ! </h3>
            <form method='post' action=''>
                <label for='scrutin'> Voici le résultat des scrutins : </label>
                <div id='scrutinResultat'>$scrutinResults</div>
            </form>
        </div> 
    ";

    echo $msg;
?>
