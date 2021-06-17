<?php

function getUserImage($imageName)
{
    return "./assets/img/" . $imageName;
}

function isLiked()
{
    return "-fill";
}

function matchFound($match)
{
    ?>
    <div class="col">
        <div class="match-card card mx-auto  mx-md-0 h-100" style="width: 18rem;">
            <img src="<?=getUserImage($match->picture)?>" alt="<?=$match->picture?>">
            <div class="match-card-body card-body">
                <div class="card-text"><?=$match->lastname?></div>
                <div class="card-text"><?=$match->firstname?></div>
                <div class="card-text"><?=$match->age?></div>
                <div class="card-text"><?=$match->zipcode?></div>
                <div class="card-text"><?=$match->description?></div>
                <form action="./developpers.php" method="POST">
                    <button type="submit" class="border-0 bg-transparent d-block ms-auto">
                        <i class="like bi bi-heart<?=isLiked()?>"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php
}

function getContent()
{
    if (!empty($_COOKIE) && isset($_COOKIE["searchGender"])) {
        $members = file_get_contents("./assets/members.json");
        $list = json_decode($members)->members;
        foreach ($list as $member) {
            if ($member->gender == strtolower($_COOKIE["searchGender"])) {
                matchFound($member);
            }
        }
    } else {
        header("Location: ./index.php");
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
<body>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php getContent()?>
        </div>
    </div>
</body>
</html>