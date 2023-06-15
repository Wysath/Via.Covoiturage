<?php
// Connexion à la base de données
require 'lib.inc.php';

$mabd = connexionBD();

// Vérification si l'utilisateur est connecté
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    echo "Mes trajets réservés :<br> <br>";
    // Requête SQL pour récupérer les réservations de l'utilisateur
    $sql = "SELECT Trajets.*, Reservations.echange, Reservations.bagages, reservations_id
            FROM Trajets 
            INNER JOIN Reservations ON Trajets.trajet_id = Reservations.trajet_id 
            WHERE Reservations.user_id = :user_id";
    $stmt = $mabd->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des réservations
    if (count($reservations) > 0) {
        foreach ($reservations as $reservation) {
            echo "Départ : " . $reservation['depart'] . "<br>";
            echo "Arrivée : " . $reservation['arrivee'] . "<br>";
            echo "Date et heure : " . $reservation['date'] . " à " . $reservation['heure'] . "<br>";
            echo "Échange : " . $reservation['echange'] . "<br>";
            echo "Bagages : " . $reservation['bagages'] . "<br>";

            // Formulaire d'annulation de réservation
            echo '<form method="POST" action="annulation.php">';
            echo '<input type="hidden" name="reservation_id" value="' . $reservation['reservations_id'] . '">';
            echo '<input type="submit" value="Annuler la réservation">';
            echo '</form>';

            echo "<br>";
        }
    } else {
        echo "Aucune réservation trouvée.";
    }
} else {
    echo "Utilisateur non connecté.";
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
