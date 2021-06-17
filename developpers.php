<?php

function getUserImage($imageName)
{
    return "./assets/img/" . $imageName;
}

function matchFound($match)
{
    ?>
    <div style="border: 1px solid black">
        <div><?=$match->firstname?></div>
        <div><?=$match->lastname?></div>
        <div><?=$match->age?></div>
        <img src="<?=getUserImage($match->picture)?>" alt="">
    </div>
    <?php
}

function getContent()
{
    if (!empty($_COOKIE) && isset($_COOKIE["searchGender"])) {
        $members = file_get_contents("./assets/members.json");
        $list = json_decode($members)->members;
        foreach ($list as $member) {
            if ($member->gender == $_COOKIE["searchGender"]) {
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
</head>
<body>
    <?php getContent()?>
</body>
</html>