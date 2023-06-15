<?php
// Connexion à la base de données
require '../lib.inc.php';

$mabd = connexionBD();

// Requête SQL pour récupérer les informations des trajets
$sql = "SELECT * FROM Trajets";
$result = $mabd->query($sql);
$trajets = $result->fetchAll(PDO::FETCH_ASSOC);

// Affichage des informations des trajets sous forme de tableau
echo '<table>
        <tr>
            <th>ID du trajet</th>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Nombre de places</th>
            <th>Action</th>
        </tr>';

foreach ($trajets as $trajet) {
    echo '<tr>';
    echo '<td>' . $trajet['trajet_id'] . '</td>';
    echo '<td>' . $trajet['depart'] . '</td>';
    echo '<td>' . $trajet['arrivee'] . '</td>';
    echo '<td>' . $trajet['date'] . '</td>';
    echo '<td>' . $trajet['heure'] . '</td>';
    echo '<td>' . $trajet['nombre_places'] . '</td>';
    echo '<td>
            <a href="edit_trajet.php?id=' . $trajet['trajet_id'] . '">Modifier</a> |
            <a href="delete_trajet.php?id=' . $trajet['trajet_id'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce trajet ?\')">Supprimer</a>
          </td>';
    echo '</tr>';
}

echo '</table>';

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
