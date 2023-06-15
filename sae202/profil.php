<?php
require 'lib.inc.php';
require 'menu_html.inc.php';

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['prenom'])) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit();
}

$mabd = connexionBD();

// Récupération de l'ID de l'utilisateur connecté
$idUtilisateur = $_SESSION['user_id'];

// Récupération des informations de l'utilisateur à partir de la base de données
$sql = "SELECT * FROM Usagers WHERE user_id = :id";
$stmt = $mabd->prepare($sql);
$stmt->bindParam(':id', $idUtilisateur);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification si le formulaire de mise à jour a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des nouvelles valeurs des champs
    $nouveauPrenom = isset($_POST["prenom"]) ? $_POST["prenom"] : '';
    $nouveauNom = isset($_POST["nom"]) ? $_POST["nom"] : '';
    $nouveauEmail = isset($_POST["email"]) ? $_POST["email"] : '';
    $nouveauMDP = isset($_POST["mdp"]) ? $_POST["mdp"] : '';
    $nouveauNum = isset($_POST["num"]) ? $_POST["num"] : '';
    $nouveauDescription = isset($_POST["description"]) ? $_POST["description"] : '';
    $nouveauVehicule = isset($_POST["vehicule"]) ? $_POST["vehicule"] : '';
    $nouveauFumeur = isset($_POST["fumeur"]) ? $_POST["fumeur"] : '';
    $nouveauAnimaux = isset($_POST["animaux"]) ? $_POST["animaux"] : '';
    $nouveauMusique = isset($_POST["musique"]) ? $_POST["musique"] : '';

    // Requête SQL pour mettre à jour les informations de l'utilisateur
    $sqlMiseAJour = "UPDATE Usagers SET prenom = :prenom, nom = :nom, usagers_email = :email, usagers_mdp = :mdp, num = :num, description = :description, vehicule = :vehicule,
                   fumeur = :fumeur, animaux = :animaux, musique = :musique WHERE user_id = :id";
    $stmtMiseAJour = $mabd->prepare($sqlMiseAJour);
    $stmtMiseAJour->bindParam(':prenom', $nouveauPrenom);
    $stmtMiseAJour->bindParam(':nom', $nouveauNom);
    $stmtMiseAJour->bindParam(':email', $nouveauEmail);
    $stmtMiseAJour->bindParam(':mdp', $nouveauMDP);
    $stmtMiseAJour->bindParam(':num', $nouveauNum);
    $stmtMiseAJour->bindParam(':description', $nouveauDescription);
    $stmtMiseAJour->bindParam(':vehicule', $nouveauVehicule);
    $stmtMiseAJour->bindParam(':fumeur', $nouveauFumeur);
    $stmtMiseAJour->bindParam(':animaux', $nouveauAnimaux);
    $stmtMiseAJour->bindParam(':musique', $nouveauMusique);
    $stmtMiseAJour->bindParam(':id', $idUtilisateur);

    // Exécution de la requête de mise à jour
    if ($stmtMiseAJour->execute()) {
        // Redirection vers la page de profil après la mise à jour réussie
        header("Location: profil.php");
        exit();
    } else {
        // Affichage d'un message d'erreur en cas d'échec de la mise à jour
        echo "Erreur lors de la mise à jour des informations.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil utilisateur</title>
</head>
<body>

<h1>Profil utilisateur</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <label>Photo de profil :</label>
    <img src="<?php echo choisirPhotoProfil($utilisateur['statut']); ?>" alt="Photo de profil"><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" value="<?php echo isset($utilisateur['prenom']) ? $utilisateur['prenom'] : ''; ?>"><br>

    <label>Nom :</label>
    <input type="text" name="nom" value="<?php echo isset($utilisateur['nom']) ? $utilisateur['nom'] : ''; ?>"><br>

    <label>Email :</label>
    <input type="text" name="email" value="<?php echo isset($utilisateur['usagers_email']) ? $utilisateur['usagers_email'] : ''; ?>"><br>

    <label>Mot de passe :</label>
    <input type="password" name="mdp" value=""><br>

    <label>Numéro de téléphone :</label>
    <input type="text" name="num" value="<?php echo isset($utilisateur['num']) ? $utilisateur['num'] : ''; ?>"><br>

    <label>Description :</label>
    <input type="text" name="description" value="<?php echo isset($utilisateur['description']) ? $utilisateur['description'] : ''; ?>"><br>

    <label>Véhicule :</label>
    <input type="text" name="vehicule" value="<?php echo isset($utilisateur['vehicule']) ? $utilisateur['vehicule'] : ''; ?>"><br>

    <label>Fumeur :</label>
    <input type="radio" name="fumeur" value="Non" <?php if (isset($utilisateur['fumeur']) && $utilisateur['fumeur'] == 'Non') echo 'checked'; ?>>Non
    <input type="radio" name="fumeur" value="Oui" <?php if (isset($utilisateur['fumeur']) && $utilisateur['fumeur'] == 'Oui') echo 'checked'; ?>>Oui<br>

    <label>Animaux :</label>
    <input type="text" name="animaux" value="<?php echo isset($utilisateur['animaux']) ? $utilisateur['animaux'] : ''; ?>"><br>

    <label>Musique :</label>
    <input type="text" name="musique" value="<?php echo isset($utilisateur['musique']) ? $utilisateur['musique'] : ''; ?>"><br>


    <input type="submit" value="Enregistrer">
</form>
</body>
</html>