<?php
// Connexion à la base de données
require '../lib.inc.php';

$mabd = connexionBD();

// Requête SQL pour récupérer les informations des utilisateurs
$sql = "SELECT user_id, prenom, nom, usagers_mdp, usagers_email, statut FROM Usagers";
$result = $mabd->query($sql);
$usagers = $result->fetchAll(PDO::FETCH_ASSOC);

// Vérification si le formulaire de suppression a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si l'ID de l'utilisateur à supprimer est passé dans le formulaire
    if (isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];

        // Requête SQL pour supprimer l'utilisateur avec l'ID spécifié
        $sqlDelete = "DELETE FROM Usagers WHERE user_id = :user_id";
        $stmt = $mabd->prepare($sqlDelete);
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();

        // Vérification si la suppression a réussi
        if ($stmt->rowCount() > 0) {
            echo "L'utilisateur a été supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'utilisateur.";
        }
    }
}

// Affichage des informations des utilisateurs sous forme de tableau
echo '<table>
        <tr>
            <th>ID</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Mot de passe</th>
            <th>Email</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>';

foreach ($usagers as $usager) {
    echo '<tr>';
    echo '<td>' . $usager['user_id'] . '</td>';
    echo '<td>' . $usager['prenom'] . '</td>';
    echo '<td>' . $usager['nom'] . '</td>';
    echo '<td>' . $usager['usagers_mdp'] . '</td>';
    echo '<td>' . $usager['usagers_email'] . '</td>';
    echo '<td>' . $usager['statut'] . '</td>';
    echo '<td>
            <form method="POST" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cet utilisateur ?\')">
                <input type="hidden" name="user_id" value="' . $usager['user_id'] . '">
                <input type="submit" value="Supprimer">
            </form>
          </td>';
    echo '</tr>';
}

echo '</table>';

// Fermeture de la connexion à la base de données
deconnexionBD($mabd);
?>
