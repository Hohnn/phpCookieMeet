<?php

$pushToCookie = ['name', 'firstname', 'age', 'gender', 'zipCode', 'email', 'searchGender'];

$redirect = false;

foreach ($pushToCookie as $cookieName) {
    if (!isset($_COOKIE[$cookieName])) {
        $redirect = true;
    }
}

if ($redirect) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["delete"])) {
    foreach ($_COOKIE as $key => $cookie) {
        setcookie($key, "", 0);
    }
    header("Location: index.php"); // change de page avec le bonne url pour récupéré en GET
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/style.css">
    <title>Profil</title>
</head>
<body class="user">
    <?php include 'navbar.php'?>
    <div class="container user-infos">
        <h1 class="my-5 fs-2">Mon Profil</h1>
        <div class="row">
            <div class="col">
                <ul>
                    <li>
                        <p>Nom : <?=$_COOKIE["name"]?></p>
                    </li>
                    <li>
                        <p>Prénom : <?=$_COOKIE["firstname"]?></p>
                    </li>
                    <li>
                        <p>Age : <?=$_COOKIE["age"]?></p>
                    </li>
                    <li>
                        <p>Genre : <?=$_COOKIE["gender"]?></p>
                    </li>
                    <li>
                        <p>Code postal : <?=$_COOKIE["zipCode"]?></p>
                    </li>
                    <li>
                        <p>Adresse mail : <?=$_COOKIE["email"]?></p>
                    </li>
                    <li>
                        <p>Recherche : <?=$_COOKIE["searchGender"]?></p>
                    </li>
                </ul>
                <form class="mt-5" action="user.php" method="post">
                    <button type="submit" class="btn btn-secondary" name="delete">SUPPRIMER LE PROFIL</button>
                    <a href="https://www.meetic.fr/" class="btn btn-secondary">TAKE MY MONEY</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>