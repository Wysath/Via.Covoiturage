<?php
require 'lib.inc.php';
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupération des trajets de l'utilisateur à partir de la base de données
$mabd = connexionBD();

$sqlTrajets = "SELECT * FROM Trajets WHERE user_id = :user_id";
$stmt = $mabd->prepare($sqlTrajets);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifie si des trajets ont été trouvés
if ($trajets) {
    // Affichage des trajets
    foreach ($trajets as $trajet) {
        echo '<p>';
        echo 'Départ : ' . $trajet['depart'] . '<br>';
        echo 'Arrivée : ' . $trajet['arrivee'] . '<br>';
        echo 'Date : ' . $trajet['date'] . '<br>';
        echo 'Heure : ' . $trajet['heure'] . '<br>';
        echo 'Nombre de places : ' . $trajet['nombre_places'] . '<br>';
        echo '<a href="modifier_trajet.php?id=' . $trajet['trajet_id'] . '">Modifier</a>';
        echo ' | ';
        echo '<a href="supprimer_trajet.php?id=' . $trajet['trajet_id'] . '">Supprimer</a>';
        echo '</p>';
    }
} else {
    echo 'Aucun trajet trouvé.';
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
