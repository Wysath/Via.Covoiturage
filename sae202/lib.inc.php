<?php

require 'secret.php';


function connexionBD(){
    $mabd=null;
    try {
        $mabd = new PDO('mysql:host=localhost;
    dbname=sae202;charset=UTF8;',
            UTILISATEUR, LEMOTDEPASSE);
        $mabd->query('SET NAMES utf8;');
    }catch (PDOException $e) {
        print "Erreur : ".$e->getMessage().'<br />'; die();
    }
    return $mabd;
}

function choisirPhotoProfil($statut)
{
    if ($statut === 'eleve') {
        return 'duck_student.jpg';
    } elseif ($statut === 'prof') {
        return 'duck_prof.jpg';
    } else {
        // Statut inconnu, renvoyer une valeur par défaut ou générer une erreur
        return 'photo_par_defaut.jpg';
    }
}

//fonction de déconnexion
function deconnexionBD(&$mabd) {

    $mabd=null;
}

