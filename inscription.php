<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page inscription</title>
</head>

<body>
    <h1 id="">Inscription</h1>
    <form action="inscription.php" method="post">
        <label for="pseudo"><b>PSEUDO: </b></label>
        <input type="text" name="psd" id="pseudo" placeholder="Entrer votre pseudo."><br />
        <label for="email"><b>E-MAIL: </b></label>
        <input type="email" name="mail" id="email" placeholder="Entrer votre mail"><br />
        <label for="password"><b>PASSWORD: </b></label>
        <input type="password" name="psw" id="passWordInscr" placeholder="Entrer votre mot de pass"><br />
        <label for="passWordConf"><b>CONFIRMATION PASSWORD: </b></label>
        <input type="password" name="pswConf" id="passWordConf" placeholder="Confirmer votre mot de pass"><br />
        <input type="submit" value="inscription">
    </form>

    <?php
    //Checking the validity of the information

    if (isset($_POST['psd']) && isset($_POST['mail'])) {

        try {
            //Connection to the database
            $bdd = new PDO('mysql:host=localhost;dbname=espace_membre_db;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            // In the event of an error, a message is displayed and everything is stopped
            die('Erreur' . $e->getMessage());
        }
        //PAssword hash
        $req = $bdd->prepare('SELECT pseudo, email FROM membres WHERE (pseudo=:pseudo AND email=:email)');
        $req->execute(array('pseudo' => htmlspecialchars($_POST['psd']), 'email' => htmlspecialchars($_POST['mail'])));
        //!$nbr = $req->rowCount(); This check is not practical, and does not work with all DBMS
        if ($row = $req->fetch()) {
            do {
                echo "<p style=\"color:red;\">Identifiants déja utilisé. </p>";
            } while ($row = $req->fetch());
        } else {
            if (isset($_POST['psw']) && isset($_POST['pswConf'])) {
                //! Check the conformity between the two passwords then insertion
                if (strcmp($_POST['psw'], $_POST['pswConf']) == 0) {
                    $pass_hache = password_hash(htmlspecialchars($_POST['psw']), PASSWORD_DEFAULT);
                    //TODO Checking the conformity of the password and its confirmation
                    //! $passConf_hache = password_hash($_POST['pswConf'], PASSWORD_DEFAULT);

                    //TODO Insertion to the database
                    $req = $bdd->prepare('INSERT INTO membres (pseudo, email, pass, date_inscription) VALUES (:pseudo,:email,:pass,:date_inscription)');
                    $req->execute(array('pseudo' => htmlspecialchars($_POST['psd']), 'email' => htmlspecialchars($_POST['mail']), 'pass' => $pass_hache, 'date_inscription' => date('Y-m-d')));
                    $req->closeCursor();
                    echo "<p style=\"color:green;\">Inscription réussie !</p>";
                } else {
                    echo "<p style=\"color:red;\">Les mots de pass saisis sont différents o_O</p>";
                }
            }
        }
    }
    ?>
</body>

</html>