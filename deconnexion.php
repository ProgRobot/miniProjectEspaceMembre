<?php
    session_start();
    $_SESSION = array();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    echo "<p>Deconnexion réussie</p>";
    header ("Refresh: 2;URL=./connexion.php"); // Wait 2 seconds then redirect to the next page
    ?>
    
</body>
</html>