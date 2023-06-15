<?php
// Connexion à la base de données
require '../lib.inc.php';

$mabd = connexionBD();

// Vérification si l'ID du trajet est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête SQL pour supprimer le trajet avec l'ID spécifié
    $sql = "DELETE FROM Trajets WHERE trajet_id = :id";
    $stmt = $mabd->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    // Vérification si la suppression a réussi
    if ($stmt->rowCount() > 0) {
        echo "Le trajet a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du trajet.";
    }
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
