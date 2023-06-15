<?php
session_start();
require 'lib.inc.php';

if (empty($_POST)) {
    header('Location: connexion.php');
    exit();
}

$email_a_nettoyer = $_POST['email'];
$mdp = $_POST['mdp'];

$email = filter_var($email_a_nettoyer, FILTER_SANITIZE_SPECIAL_CHARS);

$mabd = connexionBD();
$req = 'SELECT * FROM Usagers WHERE usagers_email LIKE :email';
$stmt = $mabd->prepare($req);
$stmt->bindValue(':email', $email); // Modifiez cette ligne

$stmt->execute();

$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
if ($ligne) {
    if ($mdp == $ligne['usagers_mdp']) {
        $_SESSION['prenom'] = $ligne['prenom'];
        $_SESSION['user_id'] = $ligne['user_id'];
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['erreur'] = '<h1>Le mot de passe saisi est incorrect.</h1>';
        header('Location: connexion.php');
        exit();
    }
} else {
    $_SESSION['erreur'] = '<h1>Aucun utilisateur trouvé avec cet e-mail.</h1>';
    header('Location: connexion.php');
    exit();
}
?>
