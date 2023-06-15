<?php
// Connexion à la base de données
require 'lib.inc.php';
$mabd = connexionBD();

// Vérification si le formulaire de création de trajet a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $depart = $_POST['depart'];
    $arrivee = $_POST['arrivee'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $nombrePlaces = $_POST['nombre_places'];

    // Vérification si l'utilisateur est connecté
    session_start();
    if (isset($_SESSION['user_id'])) {
        // Récupération de l'ID de l'utilisateur connecté
        $user_id = $_SESSION['user_id'];

        // Requête SQL pour insérer le nouveau trajet dans la table "Trajets"
        $sqlInsert = "INSERT INTO Trajets (user_id, depart, arrivee, date, heure, nombre_places) VALUES (:user_id, :depart, :arrivee, :date, :heure, :nombre_places)";
        $stmt = $mabd->prepare($sqlInsert);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':depart', $depart);
        $stmt->bindValue(':arrivee', $arrivee);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':heure', $heure);
        $stmt->bindValue(':nombre_places', $nombrePlaces);
        $stmt->execute();

        // Vérification si l'insertion a réussi
        if ($stmt->rowCount() > 0) {
            // Récupération de l'ID du trajet inséré
            $trajet_id = $mabd->lastInsertId();
            echo "<script>alert('Le trajet a été créé avec succès.');</script>";
            // Vous pouvez effectuer d'autres actions ici si nécessaire
        } else {
            echo "<script>alert('Erreur lors de la création du trajet.');</script>";
            // Vous pouvez afficher un message d'erreur ou effectuer d'autres actions ici si nécessaire
        }
    } else {
        echo "<script>alert('Utilisateur non connecté.');</script>";
        // Vous pouvez afficher un message d'erreur ou effectuer d'autres actions ici si nécessaire
    }
}

// Récupération des options de départ et d'arrivée depuis la base de données
$optionsDepart = [];
$optionsArrivee = [];

// Requête pour récupérer les options de départ
$sqlDepart = "SELECT DISTINCT depart FROM Trajets";
$resultDepart = $mabd->query($sqlDepart);
if ($resultDepart !== false) {
    $optionsDepart = [];
    while ($row = $resultDepart->fetch(PDO::FETCH_ASSOC)) {
        $optionsDepart[] = $row["depart"];
    }
}

// Requête pour récupérer les options d'arrivée
$sqlArrivee = "SELECT DISTINCT arrivee FROM Trajets";
$resultArrivee = $mabd->query($sqlArrivee);
if ($resultArrivee !== false) {
    $optionsArrivee = [];
    while ($row = $resultArrivee->fetch(PDO::FETCH_ASSOC)) {
        $optionsArrivee[] = $row["arrivee"];
    }
}

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>

<!-- Formulaire de création de trajet -->
<form method="post" action="">
    <label for="depart">Départ :</label>
    <select id="depart" name="depart" required>
        <option value="">Choisir une option</option>
        <?php
        foreach ($optionsDepart as $option) {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }
        ?>
    </select><br><br>

    <label for="arrivee">Arrivée :</label>
    <select id="arrivee" name="arrivee" required>
        <option value="">Choisir une option</option>
        <?php
        foreach ($optionsArrivee as $option) {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }
        ?>
    </select><br><br>

    <label for="date">Date :</label>
    <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required><br><br>

    <label for="heure">Heure :</label>
    <input type="time" id="heure" name="heure" required><br><br>

    <label for="nombre_places">Nombre de places :</label>
    <input type="number" id="nombre_places" name="nombre_places" required><br><br>

    <input type="submit" value="Créer trajet">
</form>
