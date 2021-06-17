<?php
    if (isset($_POST["delete"])) {
        foreach($_COOKIE as $key => $cookie){
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
    <title>Profil</title>
</head>
<body>
    <?= include('navbar') ?>
    <div class="container">
        <h1 class="text-center">Profil</h1>
        <div class="row">
            <div class="col">
                <ul>
                    <li>
                        <p>Nom : <?=  $_COOKIE["name"] ?></p>
                    </li>
                    <li>
                        <p>Prénom : <?=  $_COOKIE["firstname"] ?></p>
                    </li>
                    <li>
                        <p>Age : <?=  $_COOKIE["age"] ?></p>
                    </li>
                    <li>
                        <p>Genre : <?=  $_COOKIE["gender"] ?></p>
                    </li>
                    <li>
                        <p>Code postal : <?=  $_COOKIE["zipCode"] ?></p>
                    </li>
                    <li>
                        <p>Adresse mail : <?=  $_COOKIE["email"] ?></p>
                    </li>
                    <li>
                        <p>Recherche : <?=  $_COOKIE["searchGender"] ?></p>
                    </li>
                </ul>
                <form action="user.php" method="post">
                    <button type="submit" class="btn btn-secondary" name="delete">EFFACER</button>
                </form>
                <a href="https://www.meetic.fr/" class="btn btn-secondary">TAKE MY MONEY</a>
            </div>
        </div>
    </div>
</body>
</html>