<?php
require 'lib.inc.php';

$usagers_email = $_POST['email'];

$mabd = connexionBD();
$req =  "SELECT * FROM Usagers WHERE usagers_email LIKE :email";
$stmt = $mabd->prepare($req);
$stmt->bindParam(':email', $usagers_email);
$stmt->execute();
$resultat = $stmt->fetchAll();

// Affichage des résultats
foreach ($resultat as $row) {
    echo "Nom: " . $row['nom'] . "<br>";
    echo "Prénom: " . $row['prenom'] . "<br>";
    // Ajoutez ici les autres champs que vous souhaitez afficher
}

?>

<html>
<li><a href='index.php'>Retour à la page d'accueil</a></li>
</html>