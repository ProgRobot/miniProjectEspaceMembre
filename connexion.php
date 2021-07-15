<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page connexion</title>
</head>

<body>

    <form action="connexion.php" method="post">
        <label for="pseudoMail"><b>IDENTIFIANT: </b></label>
        <input type="text" name="psdMail" id="pseudoMail" placeholder="Entrer votre pseudo ou e-mail"><br />
        <label for="password"><b>PASSWORD: </b></label>
        <input type="password" name="pswConex" id="passWord" placeholder="Entrer votre mot de pass"><br />
        <input type="submit" value="connexion">
    </form>

    <?php

    if (isset($_POST['psdMail']) && isset($_POST['pswConex'])) {

        try {
            //Connection to the database
            $bdd = new PDO('mysql:host=localhost;dbname=espace_membre_db;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            // In the event of an error, a message is displayed and everything is stopped
            die('Erreur' . $e->getMessage());
        }

        $req = $bdd->prepare('SELECT id,pseudo, email, pass FROM espace_membre_db.membres WHERE ((pseudo=:pseudo OR email=:email))');
        $req->execute(array('pseudo' => htmlspecialchars($_POST['psdMail']), 'email' => htmlspecialchars($_POST['psdMail'])));

        if ($donnees = $req->fetch()) {
            do {
                session_start();
                $_SESSION['id'] = $donnees['id'];
                $_SESSION['pseudo'] = $donnees['pseudo'];
                header('Location: ./espaceMembrePage1.php');
            } while ($donnees = $req->fetch());
        } else {
            echo "<p>Identifiant incorrects, merci de s'inscrire</p>";
        }
    }
    ?>


<?php 
/*
//?solution alternative
//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id, pass FROM membres WHERE pseudo = :pseudo');
$req->execute(array(
    'pseudo' => $pseudo));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        echo 'Vous êtes connecté !';
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }

*/
?>

</body>
</html>