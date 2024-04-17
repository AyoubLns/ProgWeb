<?php
session_start();

if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
} else {
    header("Location: connexion.php"); 
    exit(); 
}

// Charger les scrutins depuis le fichier JSON
$scrutinsJson = file_get_contents("scrutinjs.json");
$scrutins = json_decode($scrutinsJson, true);

// Construction des boîtes de scrutin
$scrutinBoxes = '';

foreach ($scrutins["scrutins"] as $scrutin) {
    $scrutinCreator = $scrutin["email"];
    $scrutinName = $scrutin["nom_scrutin"];
    $scrutinDeadline = strtotime($scrutin["deadline"]);
    $currentDate = time();

    // Vérifier si l'utilisateur actuel est le créateur du scrutin
    if ($scrutinCreator != $email) {
        continue; // Passer au scrutin suivant si l'utilisateur n'est pas le créateur
    }

    // Input pour supprimer le scrutin
    $deleteButton = "<input type='button' class='delete-scrutin-btn' value='Supprimer ce scrutin' onclick='deleteScrutin(\"$scrutinName\")'>";

    // Input pour mettre fin au scrutin
    if ($scrutinDeadline > $currentDate) {
        $endButton = "<input type='button' class='end-scrutin-btn' value='Mettre fin au scrutin' onclick='endScrutin(\"$scrutinName\")'>";
    } else {
        $endButton = "<p> Date limite déjà passée </p>";
    }

    $scrutinBoxes .= "
        <div class='scrutin-box'>
            <p>Nom du scrutin : $scrutinName</p>
            $deleteButton
            $endButton
        </div>
    ";
}

$msg = "
    <div id='contentsmodifier'>
        <h2> Votons </h2>
        <h3> Modification des scrutins ! </h3>
        <form method='post' action=''>
            <label for='scrutin'> Veuillez modifier un scrutin </label>
            <div id='scrutinOptions'>$scrutinBoxes</div>
        </form>
    </div> 
";

echo $msg;
?>
