<?php
// Connexion à la base de données
require 'lib.inc.php';

$mabd = connexionBD();

// Requête SQL pour récupérer les informations des parkings
$sql = "SELECT * FROM Parking";
$result = $mabd->query($sql);
$parkings = $result->fetchAll(PDO::FETCH_ASSOC);

echo 'Choisissez le parking que vous souhaitez afficher !<br>&nbsp;<br>';

// Affichage de la liste déroulante
echo '<form action="" method="GET">';
echo '<select name="parking_id">';
foreach ($parkings as $parking) {
    echo '<option value="' . $parking['parking_id'] . '"';
    // Vérification si le parking est sélectionné
    if (isset($selectedParkingId) && $selectedParkingId == $parking['parking_id']) {
        echo ' selected';
    }
    echo '>' . $parking['parking_nom'] . '</option>';
}
echo '</select>';
echo '<input type="submit" value="Afficher">';
echo '</form>';


// Vérification si un parking a été sélectionné
if (isset($_GET['parking_id'])) {
    $selectedParkingId = $_GET['parking_id'];

    // Requête SQL pour récupérer les informations du parking sélectionné
    $sql = "SELECT * FROM Parking WHERE parking_id = :parking_id";
    $stmt = $mabd->prepare($sql);
    $stmt->bindParam(':parking_id', $selectedParkingId);
    $stmt->execute();
    $selectedParking = $stmt->fetch(PDO::FETCH_ASSOC);

    // Affichage des informations du parking sélectionné
    echo "Nom du parking : " . $selectedParking['parking_nom'] . "<br>";
    echo "Commentaire : " . $selectedParking['parking_comm'] . "<br>";

    // Affichage de l'image de Google Maps
    echo '<iframe src="https://www.google.com/maps/embed?pb=!' . $selectedParking['parking_map'] . '"
    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    </iframe><br><br>';

    // Ajout du lien de suppression
    // echo '<a href="admin/delete-parking.php?id=' . $selectedParking['parking_id'] . '">Supprimer ce parking</a>';
} else {
    // Si aucun parking n'est sélectionné, définir le premier parking comme sélectionné par défaut
    if (!empty($parkings)) {
        $selectedParkingId = $parkings[0]['parking_id'];
        $selectedParking = $parkings[0];

        // Affichage des informations du parking sélectionné
        echo "Nom du parking : " . $selectedParking['parking_nom'] . "<br>";
        echo "Commentaire : " . $selectedParking['parking_comm'] . "<br>";

        // Affichage de l'image de Google Maps
        echo '<iframe src="https://www.google.com/maps/embed?pb=!' . $selectedParking['parking_map'] . '"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe><br><br>';
    }
}


// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
