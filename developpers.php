<?php

function getUserImage($imageName)
{
    return "./assets/img/" . $imageName;
}

function likeMatch($liked)
{
    return $liked ? "-fill" : "";
}

function matchFound($match, $liked = false)
{
    ?>
    <div class="col">
        <div class="match-card card mx-auto mx-md-0 h-100">
            <div class="d-flex flex-column position-relative">
                <img src="<?=getUserImage($match->picture)?>" alt="<?=$match->picture?>">
                <form action="./developpers.php" method="POST">
                    <button type="submit" name="like" value="<?=$match->id?>" class="border-0 bg-transparent d-block ms-auto">
                        <i class="like bi bi-heart<?=likeMatch($liked)?>"></i>
                    </button>
                </form>
            </div>
            <div class="match-card-body card-body">
                <div class="card-text"><?=$match->lastname?></div>
                <div class="card-text"><?=$match->firstname?></div>
                <div class="card-text"><?=$match->age?> ans</div>
                <div class="card-text"><?=$match->zipcode?></div>
                <div class="card-text"><?=$match->description?></div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Gère l'ajout de cookies en tableau, s'il est déjà présent il est retiré
 */
function handleUpdatableCookieList($cookieName)
{
    // variable qui gère la valeur de retour
    $cookieContentEncode = false;

    // si le le nom du cookie à été posté
    if (isset($_POST[$cookieName])) {

        $time = time() + 24 * 60 * 60;

        // si le like cookie existe
        if (isset($_COOKIE[$cookieName])) {

            // on décode le cookie
            $cookieContent = json_decode($_COOKIE[$cookieName]);
            // on stocke l'id de la card sur laquelle on a like
            $toLikeId = $_POST[$cookieName];

            // si l'id est déjà dans l'array on le remplace - ERREUR ??? o_O
            if (($id = array_search($toLikeId, $cookieContent)) !== false) {
                array_splice($cookieContent, $id, 1);
            } else { # sinon on le place dans l'array
            $cookieContent[] = $toLikeId;
            }

            // on stringify l'array et on le place dans le cookie
            $cookieContentEncode = json_encode($cookieContent);
            setcookie($cookieName, $cookieContentEncode, $time);

        } else { # si le cookie n'existe pas on le crée
        $cookieContentEncode = json_encode([$_POST[$cookieName]]);
            setcookie($cookieName, $cookieContentEncode, $time);
        }

    } elseif (isset($_COOKIE[$cookieName])) { # si aucun like a été submit on regarde si le cookie existe
    $cookieContentEncode = $_COOKIE[$cookieName]; # on paramètre la valeur retour à la valeur du cookie
}
    return $cookieContentEncode;
}

function getContent()
{
    $pushToCookie = ['name', 'firstname', 'age', 'gender', 'zipCode', 'email', 'searchGender'];

    // filtre homme / femme trouvés
    if (!empty($_COOKIE)) {
        $allCookiesAreSet = true; # par défaut tous les cookies

        foreach ($pushToCookie as $cookieName) {
            if (!isset($_COOKIE[$cookieName])) {
                $allCookiesAreSet = false;
            }
        }

        if ($allCookiesAreSet) {
            // pour le cas d'un submit "like"
            $likedInput = handleUpdatableCookieList("like");
            $members = file_get_contents("./assets/members.json");
            $list = json_decode($members)->members;
            foreach ($list as $member) {
                if ($member->gender == strtolower($_COOKIE["searchGender"])) {
                    $inArray = $likedInput ? in_array($member->id, json_decode($likedInput)) : $likedInput;
                    matchFound($member, $inArray);
                }
            }

        } else {
            header("Location: ./index.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body class="developpers">
    <?php include "navbar.php"?>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php getContent()?>
        </div>
    </div>
</body>
</html>