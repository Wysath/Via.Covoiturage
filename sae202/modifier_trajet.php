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

// Le trajet existe et appartient à l'utilisateur, on peut afficher le formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $depart = $_POST['depart'];
    $arrivee = $_POST['arrivee'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $nombrePlaces = $_POST['nombre_places'];

    // Requête SQL pour mettre à jour le trajet dans la base de données
    $sqlUpdateTrajet = "UPDATE Trajets SET depart = :depart, arrivee = :arrivee, date = :date, heure = :heure, nombre_places = :nombre_places WHERE trajet_id = :trajet_id";
    $stmtUpdateTrajet = $mabd->prepare($sqlUpdateTrajet);
    $stmtUpdateTrajet->bindValue(':depart', $depart);
    $stmtUpdateTrajet->bindValue(':arrivee', $arrivee);
    $stmtUpdateTrajet->bindValue(':date', $date);
    $stmtUpdateTrajet->bindValue(':heure', $heure);
    $stmtUpdateTrajet->bindValue(':nombre_places', $nombrePlaces);
    $stmtUpdateTrajet->bindValue(':trajet_id', $trajet_id);
    $stmtUpdateTrajet->execute();

    // Vérifier si la mise à jour a réussi
    if ($stmtUpdateTrajet->rowCount() > 0) {
        // Rediriger vers la page des trajets de l'utilisateur ou afficher un message de succès
        header("Location: trajets_utilisateur.php");
        exit;
    } else {
        // Rediriger vers une page d'erreur ou afficher un message d'erreur
        header("Location: trajet_invalide.php");
        exit;
    }
} else {
    // Requête SQL pour récupérer les détails du trajet
    $sqlTrajet = "SELECT * FROM Trajets WHERE trajet_id = :trajet_id";
    $stmtTrajet = $mabd->prepare($sqlTrajet);
    $stmtTrajet->bindValue(':trajet_id', $trajet_id);
    $stmtTrajet->execute();

    // Vérifier si le trajet existe
    if ($stmtTrajet->rowCount() === 0) {
        // Rediriger vers une page d'erreur ou afficher un message d'erreur
        header("Location: trajet_invalide.php");
        exit;
    }

    // Récupérer les détails du trajet
    $trajet = $stmtTrajet->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Formulaire de modification de trajet -->
<form method="post" action="modifier_trajet.php?id=<?php echo $trajet_id; ?>">
    <label for="depart">Départ :</label>
    <input type="text" id="depart" name="depart" value="<?php echo $trajet['depart']; ?>" required><br><br>

    <label for="arrivee">Arrivée :</label>
    <input type="text" id="arrivee" name="arrivee" value="<?php echo $trajet['arrivee']; ?>" required><br><br>

    <label for="date">Date :</label>
    <input type="date" id="date" name="date" value="<?php echo $trajet['date']; ?>" required><br><br>

    <label for="heure">Heure :</label>
    <input type="time" id="heure" name="heure" value="<?php echo $trajet['heure']; ?>" required><br><br>

    <label for="nombre_places">Nombre de places :</label>
    <input type="number" id="nombre_places" name="nombre_places" value="<?php echo $trajet['nombre_places']; ?>" required><br><br>

    <input type="submit" value="Modifier trajet">
</form>
