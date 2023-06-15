<?php
// Connexion à la base de données
require 'lib.inc.php';

$mabd = connexionBD();

// Vérification de la connexion

// Récupération des options de départ, d'arrivée et d'heure depuis la base de données
$optionsDepart = [];
$optionsArrivee = [];
$optionsHeure = [];

// Requête pour récupérer les options de départ
$sqlDepart = "SELECT DISTINCT depart FROM Trajets";
$resultDepart = $mabd->query($sqlDepart);
if ($resultDepart !== false) {
    $optionsDepart = [];
    while ($row = $resultDepart->fetch(PDO::FETCH_ASSOC)) {
        $optionsDepart[] = $row["depart"];
    }
}

// Requête pour récupérer les options d'arrivée
$sqlArrivee = "SELECT DISTINCT arrivee FROM Trajets";
$resultArrivee = $mabd->query($sqlArrivee);
if ($resultArrivee !== false) {
    $optionsArrivee = [];
    while ($row = $resultArrivee->fetch(PDO::FETCH_ASSOC)) {
        $optionsArrivee[] = $row["arrivee"];
    }
}

// Requête pour récupérer les options d'heure
$sqlHeure = "SELECT DISTINCT heure FROM Trajets";
$resultHeure = $mabd->query($sqlHeure);
if ($resultHeure !== false) {
    $optionsHeure = [];
    while ($row = $resultHeure->fetch(PDO::FETCH_ASSOC)) {
        $optionsHeure[] = $row["heure"];
    }
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sélection de trajet</title>
    <style>
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        #popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            text-align: center;
            display: none;
        }

        #popup h2 {
            margin-top: 0;
        }

        #acceptBtn {
            padding: 10px 20px;
            background-color: #337ab7;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var overlay = document.getElementById("overlay");
            var popup = document.getElementById("popup");
            var acceptBtn = document.getElementById("acceptBtn");

            acceptBtn.addEventListener("click", function() {
                overlay.remove();
                popup.remove();
                // Enregistrez l'acceptation de l'utilisateur.
            });

            // Vérifiez si l'utilisateur a déjà accepté (par exemple, en vérifiant les cookies).
            // Si l'utilisateur a déjà accepté, masquez le pop-up.
            // Sinon, affichez le pop-up.
            var userAccepted = false;
            if (!userAccepted) {
                overlay.style.display = "block";
                popup.style.display = "block";
            }
        });
    </script>
</head>
<body>
<div id="overlay"></div>
<div id="popup">
    <h2>Veuillez accepeter les cookies</h2>
    <button id="acceptBtn">Accepter</button>
</div>

<h1>Sélection de trajet</h1>

<!-- Formulaire de recherche de trajet -->
<form method="post" action="resultats_trajet.php">
    <label for="depart">Départ :</label>
    <select id="depart" name="depart" required>
        <option value="">Choisir une option</option>
        <?php
        foreach ($optionsDepart as $option) {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }
        ?>
    </select><br><br>

    <label for="arrivee">Arrivée :</label>
    <select id="arrivee" name="arrivee" required>
        <option value="">Choisir une option</option>
        <?php
        foreach ($optionsArrivee as $option) {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }
        ?>
    </select><br><br>

    <label for="heure">Heure :</label>
    <select id="heure" name="heure" required>
        <option value="">Choisir une option</option>
        <?php
        foreach ($optionsHeure as $option) {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }
        ?>
    </select><br><br>

    <label for="date">Date :</label>
    <input type="date" id="date" name="date" min="<?= date('Y-m-d') ?>" required><br><br>

    <label for="places">Nombre de places :</label>
    <input type="number" id="places" name="places" min="1" required><br><br>

    <input type="submit" value="Rechercher">
</form>

<br><br>
</body>
</html>
