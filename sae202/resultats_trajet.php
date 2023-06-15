<?php
// Connexion à la base de données
require 'lib.inc.php';

$mabd = connexionBD();

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des valeurs sélectionnées dans le formulaire
    $depart = $_POST["depart"];
    $arrivee = $_POST["arrivee"];
    $date = $_POST["date"];

    // Requête SQL pour récupérer les trajets correspondants
    $sql = "SELECT Trajets.*, nom 
            FROM Trajets 
            INNER JOIN Usagers ON Trajets.user_id = Usagers.user_id
            WHERE depart = :depart AND arrivee = :arrivee AND date >= :date";
    $stmt = $mabd->prepare($sql);
    $stmt->bindParam(':depart', $depart);
    $stmt->bindParam(':arrivee', $arrivee);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des résultats
    if (count($resultats) > 0) {
        foreach ($resultats as $resultat) {
            echo "Trajet de " . $resultat['depart'] . " à " . $resultat['arrivee'] . "<br>";
            echo "Nom de la personne : " . $resultat['nom'] . "<br>";

            // Requête SQL pour récupérer le nombre de réservations pour ce trajet
            $trajetId = $resultat['trajet_id'];
            $sqlReservation = "SELECT COUNT(*) AS reservations FROM Reservations WHERE trajet_id = :trajetId";
            $stmtReservation = $mabd->prepare($sqlReservation);
            $stmtReservation->bindParam(':trajetId', $trajetId);
            $stmtReservation->execute();
            $reservationResult = $stmtReservation->fetch(PDO::FETCH_ASSOC);

            $placesDisponibles = $resultat['nombre_places'] - $reservationResult['reservations'];

            echo "Nombre de places disponibles : " . $placesDisponibles . "<br>";

            echo "Date et heure : " . $resultat['date'] . " à " . $resultat['heure'] . "<br><br>";

            // Requête SQL pour récupérer les détails des réservations pour ce trajet
            $sqlReservationsTrajet = "SELECT Reservations.*, Usagers.prenom 
                                      FROM Reservations 
                                      INNER JOIN Usagers ON Reservations.user_id = Usagers.user_id
                                      WHERE trajet_id = :trajetId";
            $stmtReservationsTrajet = $mabd->prepare($sqlReservationsTrajet);
            $stmtReservationsTrajet->bindParam(':trajetId', $trajetId);
            $stmtReservationsTrajet->execute();
            $reservationsTrajet = $stmtReservationsTrajet->fetchAll(PDO::FETCH_ASSOC);

            if (count($reservationsTrajet) > 0) {
                echo "Personnes ayant déjà réservé :<br>";

                foreach ($reservationsTrajet as $reservation) {
                    echo $reservation['prenom'] . "<br>";
                }
            } else {
                echo "Aucune réservation pour le moment.<br>";
            }

            // Formulaire de réservation
            if ($placesDisponibles > 0) {
                echo '<form method="post" action="reservation.php">';
                echo '<input type="hidden" name="trajet_id" value="' . $resultat['trajet_id'] . '">';
                echo '<input type="submit" value="Réserver">';
                echo '</form>';
            } else {
                echo 'Complet<br><br>';
            }

            echo "<br><br>";
        }
    } else {
        echo "Aucun trajet disponible pour cette recherche.";
    }
}
?>

</body>
</html>
