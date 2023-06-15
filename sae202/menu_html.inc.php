<header>
  <nav>
        <a href="index.php">Accueil</a> -
        <?php
        session_start();
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['prenom'])) {
            // Afficher un message de bienvenue avec le prénom de l'utilisateur
            echo "<h1>Bienvenue " . $_SESSION['prenom'] . " !</h1>";

            // Afficher un lien de déconnexion
            echo "<a href='deconnexion.php'>Déconnexion</a>";
        } else {
            // Afficher un lien de connexion
            echo "<a href='connexion.php'>Connexion</a>";
        }
        ?>

        <a href="inscription.php">Inscription</a>
    </nav>
</header>
