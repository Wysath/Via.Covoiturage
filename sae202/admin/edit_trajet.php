<?php
// Connexion à la base de données
require '../lib.inc.php';

$mabd = connexionBD();

// Vérification si l'ID du trajet est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête SQL pour récupérer les informations du trajet avec l'ID spécifié
    $sql = "SELECT * FROM Trajets WHERE trajet_id = :id";
    $stmt = $mabd->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    // Récupération des données du trajet
    $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification si le formulaire de modification a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $depart = $_POST['depart'];
        $arrivee = $_POST['arrivee'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $nombrePlaces = $_POST['nombre_places'];

        // Requête SQL pour mettre à jour le trajet avec les nouvelles données
        $sql = "UPDATE Trajets SET depart = :depart, arrivee = :arrivee, date = :date, heure = :heure, nombre_de_places = :nombre_places WHERE trajet_id = :id";
        $stmt = $mabd->prepare($sql);
        $stmt->bindValue(':depart', $depart);
        $stmt->bindValue(':arrivee', $arrivee);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':heure', $heure);
        $stmt->bindValue(':nombre_places', $nombrePlaces);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        // Vérification si la mise à jour a réussi
        if ($stmt->rowCount() > 0) {
            echo "Le trajet a été mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du trajet.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier le trajet</title>
</head>
<body>
<?php if ($trajet): ?>
    <h1>Modifier le trajet</h1>
    <form method="POST">
        <label for="depart">Départ:</label>
        <input type="text" name="depart" value="<?php echo $trajet['depart']; ?>"><br><br>

        <label for="arrivee">Arrivée:</label>
        <input type="text" name="arrivee" value="<?php echo $trajet['arrivee']; ?>"><br><br>

        <label for="date">Date:</label>
        <input type="text" name="date" value="<?php echo $trajet['date']; ?>"><br><br>

        <label for="heure">Heure:</label>
        <input type="text" name="heure" value="<?php echo $trajet['heure']; ?>"><br><br>

        <label for="nombre_places">Nombre de places:</label>
        <input type="text" name="nombre_places" value="<?php echo $trajet['nombre_de_places']; ?>"><br><br>

        <input type="submit" value="Enregistrer">
    </form>
<?php else: ?>
    <p>Le trajet spécifié n'existe pas.</p>
<?php endif; ?>

<a href="gestion_trajet.php">Retourner à la liste des trajets</a>

<?php
// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
</body>
</html>
