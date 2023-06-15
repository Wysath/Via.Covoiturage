<?php
$headers = array();
$headers['MIME-Version'] = '1.0';
$headers['content-type'] = 'text/html; charset=utf-8';
?>

<?php
// Vérification de l'appel via le formulaire
if (count($_POST)==0) {
    // Si le le tableau est vide, on affiche le formulaire
    header('location: ../contact.php');
}

// Récupération des données du formulaire
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$message=$_POST['message'];
$email=$_POST['email'];
$envoi=$_POST['envoi'];
$message = $message . "demande de type " .$envoi;

// Traitement des données

// $prenom=mb_strtolower($prenom);
// $nom=mb_strtolower($nom);

//Préparation des variables pour l'envoi du mail de contact
$subject='SAE202 : demande de '.$prenom.' '.$nom;
$headers['From']=$email;
$headers['Reply-to']=$email;
$headers['X-Mailer']='PHP/'.phpversion();


$email_dest="mmi22e09@mmi-troyes.fr";

if (mail($email_dest,$subject,$message,$headers)) {
    echo "Mail de Contact OK";
}else {
    echo "Erreur d'envoi du mail de contact<br>";
}

$subject='Bonjour '.$prenom.' '.$nom;
$headers['From']='mmi22e09@mmi-troyes.fr';
$headers['Reply-to']=$email;
$headers['X-Mailer']='PHP/'.phpversion();

$email_dest=$email;

//Envoi du mail avec confirmation d'envoi (ou pas)
if (mail($email_dest,$subject,$message,$headers)) {
    echo "Nous avons bien pris en compte votre demande.<br>";
}else {
    echo "Erreur d'envoi du mail de contact<br>";
}

$affichage_retour = '';
$erreurs=0;

// Vérification des données du formulaire
// Exemple pour le nom

if (!empty($_POST['nom'])) {
    $nom=$_POST['nom'];
} else {
    $affichage_retour .='Le champ NOM est obligatoire<br>';
    $erreurs++;
}

if (!empty($_POST['prenom'])) {
    $nom=$_POST['prenom'];
} else {
    $affichage_retour .='Le champ PRENOM est obligatoire<br>';
    $erreurs++;
}

if (!empty($_POST['email'])) {
    if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
        $email=$_POST['email'];
    } else {
        $affichage_retour .='Adresse mail incorrecte<br>';
        $erreurs++;
    }

} else {
    $affichage_retour .='Le champ EMAIL est obligatoire<br>';
    $erreurs++;
}

if ($erreurs == 0) {
    if (mail($email_dest,$subject,$message,$headers)) {
        $erreurs=0;
    } else {
        $erreurs++;
    }

    if (mail($email_dest,$subject,$message,$headers)) {
        $erreurs=0;
    } else {
        $erreurs++;
    }
    $affichage_retour='Votre demande à bien été envoyée';

    if($envoi== "informations")$affichage_retour='Votre demande d/information a bien été prise en compte';
    if($envoi== "demande")$affichage_retour='Votre demande de devis a été transmise';
    if($envoi== "reclamation")$affichage_retour='Votre réclamation sera traitée dans les meilleurs délais';

    if ($erreurs != 0) {
        $affichage_retour='Echec de l\'envoi du message';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>envoi_mail</title>
    <meta charset="utf-8">
</head>
<div>
    <body>
    <main>
        <?php

        //echo 'Votre nom : '.ucfirst($prenom).' '.ucfirst($nom).'<br>';
        //echo 'Adresse mail : '.$email.'<br>';
        //echo 'Message : '.$message.'<br>';

        if ($erreurs == 0) {                                       // aucune erreur
            echo '<div>'."\n";
            echo '<p>'.$affichage_retour.'</p>'."\n";
            echo '<form action="../index.php">'."\n";
            echo '<button type="submit">Retour</button>'."\n";        // on retourne sur la page accuei
            echo '</form>'."\n";
            echo '</div>'."\n";

        } else {   //erreur de saisie ou d'envoi de mail                                               // Erreurs de saisie ou d'envoi du mail

            echo '<div>'."\n";
            echo '<p>'.$affichage_retour.'</p>'."\n";
            echo '<form action="../contact.php">'."\n";
            echo '<button type="submit">Retour</button>'."\n";        // on retourne sur la page accueil
            echo '</form>'."\n";
            echo '</div>'."\n";
        }
        ?>
    </main>
    </body>
</div>

</html>