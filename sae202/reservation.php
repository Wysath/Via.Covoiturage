<?php
// Connexion à la base de données
require 'lib.inc.php';

$mabd = connexionBD();

// Vérification si le formulaire de réservation a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des valeurs du formulaire
    $trajet_id = $_POST["trajet_id"];
    $echange = isset($_POST["echange"]) ? $_POST["echange"] : "";
    $bagages = isset($_POST["bagages"]) ? $_POST["bagages"] : "";

    // Vérification si l'utilisateur est connecté
    session_start();
    if (isset($_SESSION['user_id'])) {
        // Récupération de l'identifiant de l'utilisateur
        $user_id = $_SESSION['user_id'];

        // Requête SQL pour vérifier si l'utilisateur et le trajet existent
        $sqlCheck = "SELECT * FROM Usagers WHERE user_id = :user_id";
        $stmtCheck = $mabd->prepare($sqlCheck);
        $stmtCheck->bindValue(':user_id', $user_id);
        $stmtCheck->execute();

        // Vérification si l'utilisateur existe
        if ($stmtCheck->rowCount() > 0) {
            // Requête SQL pour insérer la réservation dans la table
            $sqlInsert = "INSERT INTO Reservations (echange, bagages, user_id, trajet_id) VALUES (:echange, :bagages, :user_id, :trajet_id)";
            $stmtInsert = $mabd->prepare($sqlInsert);
            $stmtInsert->bindValue(':echange', $echange);
            $stmtInsert->bindValue(':bagages', $bagages);
            $stmtInsert->bindValue(':user_id', $user_id);
            $stmtInsert->bindValue(':trajet_id', $trajet_id);
            $stmtInsert->execute();

            // Vérification si l'insertion a réussi
            if ($stmtInsert->rowCount() > 0) {
                echo "<script>alert('Votre trajet a bien été réservé.');</script>";
            } else {
                echo "<script>alert('Erreur lors de la réservation du trajet.');</script>";
            }
        } else {
            echo "<script>alert('L\'utilisateur n\'existe pas.');</script>";
        }
    } else {
        echo "<script>alert('Utilisateur non connecté.');</script>";
    }
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
