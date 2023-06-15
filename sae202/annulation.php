<?php
// Connexion à la base de données
require 'lib.inc.php';

$mabd = connexionBD();

// Vérification si l'utilisateur est connecté
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Vérification si l'ID de réservation est passé en tant que paramètre
    if (isset($_POST['reservation_id'])) {
        $reservation_id = $_POST['reservation_id'];

        // Requête SQL pour vérifier si la réservation appartient à l'utilisateur connecté
        $sql = "SELECT * FROM Reservations WHERE reservations_id = :reservations_id AND user_id = :user_id";
        $stmt = $mabd->prepare($sql);
        $stmt->bindParam(':reservations_id', $reservation_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reservation) {
            // Supprimer la réservation de la base de données
            $sqlDelete = "DELETE FROM Reservations WHERE reservations_id = :reservation_id";
            $stmtDelete = $mabd->prepare($sqlDelete);
            $stmtDelete->bindParam(':reservation_id', $reservation_id);

            if ($stmtDelete->execute()) {
                echo "La réservation a été annulée avec succès.";
            } else {
                echo "Une erreur est survenue lors de l'annulation de la réservation.";
            }
        } else {
            echo "Vous n'êtes pas autorisé à annuler cette réservation.";
        }
    } else {
        echo "ID de réservation manquant.";
    }
} else {
    echo "Utilisateur non connecté.";
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
