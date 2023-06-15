<?php
// Connexion à la base de données
require '../lib.inc.php';

$mabd = connexionBD();

// Vérification si l'ID du parking est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête SQL pour récupérer les informations du parking avec l'ID spécifié
    $sql = "SELECT * FROM Parking WHERE parking_id = :id";
    $stmt = $mabd->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    // Récupération des données du parking
    $parking = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification si le formulaire de modification a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $nom = $_POST['nom'];
        $commentaire = $_POST['commentaire'];

        // Requête SQL pour mettre à jour le parking avec les nouvelles données
        $sql = "UPDATE Parking SET parking_nom = :nom, parking_comm = :commentaire WHERE parking_id = :id";
        $stmt = $mabd->prepare($sql);
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':commentaire', $commentaire);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        // Vérification si la mise à jour a réussi
        if ($stmt->rowCount() > 0) {
            echo "Le parking a été mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du parking.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier le parking</title>
</head>
<body>
<?php if ($parking): ?>
    <h1>Modifier le parking</h1>
    <form method="POST">
        <label for="nom">Nom du parking:</label>
        <input type="text" name="nom" value="<?php echo $parking['parking_nom']; ?>"><br><br>

        <label for="commentaire">Commentaire:</label>
        <textarea name="commentaire"><?php echo $parking['parking_comm']; ?></textarea><br><br>

        <input type="submit" value="Enregistrer">
    </form>
<?php else: ?>
    <p>Le parking spécifié n'existe pas.</p>
<?php endif; ?>

<a href="gestion_parking.php">Retourner à la liste des parkings</a>

<?php
// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
</body>
</html>
