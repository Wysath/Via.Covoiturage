<?php
require 'lib.inc.php';
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion ou afficher un message d'erreur
    header("Location: login.php");
    exit;
}

// Vérification si l'identifiant du trajet est fourni dans l'URL
if (!isset($_GET['id'])) {
    // Rediriger vers une page d'erreur ou afficher un message d'erreur
    header("Location: trajet_invalide.php");
    exit;
}

// Récupération de l'identifiant du trajet depuis l'URL
$trajet_id = $_GET['id'];

// Connexion à la base de données
$mabd = connexionBD();

// Requête SQL pour vérifier si le trajet appartient à l'utilisateur connecté
$sqlCheckTrajet = "SELECT * FROM Trajets WHERE trajet_id = :trajet_id AND user_id = :user_id";
$stmtCheckTrajet = $mabd->prepare($sqlCheckTrajet);
$stmtCheckTrajet->bindValue(':trajet_id', $trajet_id);
$stmtCheckTrajet->bindValue(':user_id', $_SESSION['user_id']);
$stmtCheckTrajet->execute();

// Vérifier si le trajet existe et appartient à l'utilisateur
if ($stmtCheckTrajet->rowCount() === 0) {
    // Rediriger vers une page d'erreur ou afficher un message d'erreur
    header("Location: trajet_invalide.php");
    exit;
}

// Le trajet existe et appartient à l'utilisateur, on peut le supprimer
$sqlDeleteTrajet = "DELETE FROM Trajets WHERE trajet_id = :trajet_id";
$stmtDeleteTrajet = $mabd->prepare($sqlDeleteTrajet);
$stmtDeleteTrajet->bindValue(':trajet_id', $trajet_id);
$stmtDeleteTrajet->execute();

// Vérifier si la suppression a réussi
if ($stmtDeleteTrajet->rowCount() > 0) {
    // Rediriger vers la page des trajets de l'utilisateur ou afficher un message de succès
    header("Location: trajets_utilisateur.php");
    exit;
} else {
    // Rediriger vers une page d'erreur ou afficher un message d'erreur
    header("Location: trajet_invalide.php");
    exit;
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
