<!DOCTYPE html>
<html>
<head>
    <title>Page d'accueil</title>
</head>
<body>
<h1>Bienvenue sur notre site de Covoiturage</h1>

<?php
// Ton code PHP ici

// Exemple d'affichage de la date actuelle
$date = date('d/m/Y');
echo "<p>Aujourd'hui, nous sommes le $date.</p>";
?>

<p>Voici les liens importants :</p>
<ul>
    <li><a href="connexion.php">Page de connexion</a></li>
    <li><a href="inscription.php">Page d'inscription</a></li>
    <li><a href="trajet.php">Page de trajets</a></li>
    <li><a href="creer_trajet.php">Page de création des trajets</a></li>
    <li><a href="parking.php">Page parking</a> </li>
    <li><a href="contact.php">Page contact</a> </li>
    <li><a href="trajets_utilisateur.php">Page où l'utilisateur peut voir ses trajets crées</a> </li>
    <li><a href="reservations_utilisateur.php">Page des réservations de l'utilisateur</a> </li>
    <li><a href="profil.php">Voir/Mettre à jour mon profil</a></li>
</ul>
</body>
</html>
