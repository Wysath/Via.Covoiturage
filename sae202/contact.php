<!DOCTYPE html>
<html>
<head>
    <title>CONTACT  </title>
    <meta charset="utf-8">
</head>
<body>

<main>
    <h1>Contactez-nous!</h1>
    <div>
        <form action="traitements/envoi_mail.php" method="post">
            <div id="en-tete">
                <div>
                    <label for="prenom">Prénom <span>*</span></label>
                    <input type="text" name="prenom" id="prenom" placeholder="John" required/>
                </div>
                <div>
                    <label for="nom">Nom <span>*</span></label>
                    <input type="text" name="nom" id="nom" placeholder="Doe" required/>
                </div>
            </div>
            <div id="bas">
                <label for="email">E-mail <span>*</span></label>
                <input type="email" name="email" id="email" placeholder="nom@domaine.fr" required/>

                <label for="message">Message <span>*</span></label>
                <textarea type="message" name="message" id="message" placeholder="Votre message" required></textarea>
            </div>
            <div>
                <input type="radio" id="informations" name="envoi" value="informations">
                <label for="informations">Informations</label><br>

                <input type="radio" id="demande" name="envoi" value="demande">
                <label for="demande">Demande de devis</label><br>

                <input type="radio" id="reclamation" name="envoi" value="reclamation">
                <label for="reclamation">Réclamation</label>
            </div>
            <div>
                <input type="submit" value="Envoyer"/>
            </div>
        </form>
    </div>
</main>
</body>



</html>