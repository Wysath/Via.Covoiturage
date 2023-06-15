<?php
require '../lib.inc.php';

echo "Bienvenue sur la page de Gestion !";
?>

<html>

<ul>
    <li><a href="gestion_parking.php">Gérer les parkings</a></li>
    <li><a href="gestion_trajets.php">Gérer les trajets</a></li>
    <li><a href="delete_usagers.php">Supprimer un usager</a></li>
</ul>

</html>

<?php

$mabd=connexionBD();


// Requête SQL pour récupérer le nombre d'usagers
$sql = "SELECT COUNT(*) AS nombre_usagers FROM Usagers";
$result = $mabd->query($sql);
$nombreUsagers = $result->fetchColumn();

// Requête SQL pour récupérer le nombre de trajets
$sql = "SELECT COUNT(*) AS nombre_trajets FROM Trajets";
$result = $mabd->query($sql);
$nombreTrajets = $result->fetchColumn();

// Affichage du nombre de trajets
echo "Nombre de trajets : " . $nombreTrajets ."<br>";

// Affichage du nombre d'usagers
echo "Nombre d'usagers : " . $nombreUsagers;

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);

