<?php
session_start();

// Destruction de toutes les variables de session
session_unset();

// Destruction de la session
session_destroy();

// Redirection vers la page d'accueil ou toute autre page après la déconnexion
header("Location: index.php");
exit;

