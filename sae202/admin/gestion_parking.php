<?php
// Connexion à la base de données
require '../lib.inc.php';

$mabd = connexionBD();

// Requête SQL pour récupérer les informations des parkings
$sql = "SELECT * FROM Parking";
$result = $mabd->query($sql);
$parkings = $result->fetchAll(PDO::FETCH_ASSOC);

// Affichage des informations des parkings sous forme de tableau
echo '<table>
        <tr>
            <th>Nom du parking</th>
            <th>Commentaire</th>
            <th>Action</th>
        </tr>';

foreach ($parkings as $parking) {
    echo '<tr>';
    echo '<td>' . $parking['parking_nom'] . '</td>';
    echo '<td>' . $parking['parking_comm'] . '</td>';
    echo '<td>
            <a href="edit_parking.php?id=' . $parking['parking_id'] . '">Modifier</a> |
            <a href="delete-parking.php?id=' . $parking['parking_id'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce parking ?\')">Supprimer</a>
          </td>';
    echo '</tr>';
}

echo '</table>';

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
