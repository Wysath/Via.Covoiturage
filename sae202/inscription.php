<?php
require 'lib.inc.php';

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des valeurs saisies dans le formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $num = $_POST["num"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $statut = $_POST["statut"];
    $age = $_POST["age"];

    // Connexion à la base de données
    $mabd=connexionBD();

    // Requête SQL pour insérer les informations dans la base de données
    $req = "INSERT INTO Usagers (nom, usagers_email, prenom, num, age, usagers_mdp, statut, photo_profil) VALUES (:nom, :email, :prenom, :num, :age, :mdp, :statut, :photo_profil)";

    // Appel de la fonction pour choisir le nom du fichier d'image de profil
    $nomFichierPhoto = choisirPhotoProfil($statut);

    // Préparation de la requête avec des paramètres nommés
    $stmt = $mabd->prepare($req);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':num', $num);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->bindParam(':statut', $statut);
    $stmt->bindParam(':photo_profil', $nomFichierPhoto);

    if ($stmt->execute()) {
        // Enregistrement réussi
        echo "Enregistrement réussi !";
    } else {
        // Erreur lors de l'enregistrement
        echo "Erreur lors de l'enregistrement : ";
    }

    // Fermeture de la connexion à la base de données
    deconnexionBD($mabd);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page d'inscription</title>
</head>
<body>
<h1>Inscription</h1>

<form action="inscription.php" method="post">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required><br><br>

    <label for="prenom">Prénom:</label>
    <input type="text" id="prenom" name="prenom" required><br><br>

    <label for="num">Numéro :</label>
    <input type="text" id="num" name="num" required><br><br>

    <label for="age">Age :</label>
    <input type="text" id="age" name="age" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="mdp">Mot de passe:</label>
    <input type="password" id="mdp" name="mdp" required><br><br>

    <label>Statut:</label>
    <div>
        <input type="radio" id="eleve" name="statut" value="eleve" checked>
        <label for="eleve">Élève</label>
    </div>
    <div>
        <input type="radio" id="prof" name="statut" value="prof">
        <label for="prof">Professeur</label>
    </div>

    <input type="submit" value="S'inscrire">
</form>

</body>
</html>
