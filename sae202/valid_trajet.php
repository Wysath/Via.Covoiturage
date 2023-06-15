<?php
// Connexion à la base de données
require 'lib.inc.php';
$mabd = connexionBD();

// Vérification si le formulaire de création de trajet a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $depart = $_POST['depart'];
    $arrivee = $_POST['arrivee'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $nombrePlaces = $_POST['nombre_places'];

    // Vérification si l'utilisateur est connecté
    session_start();
    if (isset($_SESSION['user_id'])) {
        // Récupération de l'ID de l'utilisateur connecté
        $user_id = $_SESSION['user_id'];

        // Requête SQL pour insérer le nouveau trajet dans la table "Trajets"
        $sqlInsert = "INSERT INTO Trajets (user_id, depart, arrivee, date, heure, nombre_places) VALUES (:user_id, :depart, :arrivee, :date, :heure, :nombre_places)";
        $stmt = $mabd->prepare($sqlInsert);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':depart', $depart);
        $stmt->bindValue(':arrivee', $arrivee);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':heure', $heure);
        $stmt->bindValue(':nombre_places', $nombrePlaces);
        $stmt->execute();

        // Vérification si l'insertion a réussi
        if ($stmt->rowCount() > 0) {
            // Récupération de l'ID du trajet inséré
            $trajet_id = $mabd->lastInsertId();
            echo "Le trajet a été créé avec succès.";
        } else {
            echo "Erreur lors de la création du trajet.";
        }
    } else {
        echo "Utilisateur non connecté.";
    }
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
