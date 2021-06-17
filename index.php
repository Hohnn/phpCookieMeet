<?php
function isValid($pattern ,$subject){   //vérifie la regex puis renvoi vrai ou faux
    if (preg_match($pattern, $subject)) {
        return true;
    } else {
        return false;
    }
}

function mailExist($element, $array){ //compart le mail avec les mails existant et renvoi vrai si elle n'est pas trouvé
    if (in_array($element, $array)) {
        return false;
    } else { 
        return true;
    }
}

$name = htmlspecialchars($_POST['name'] ?? 'Vide');
$firstname = htmlspecialchars($_POST['firstname'] ?? 'Vide') ;
$age = htmlspecialchars($_POST['age'] ?? 'Vide') ;
$gender = htmlspecialchars($_POST['gender'] ?? 'Vide') ;
$zipCode = htmlspecialchars($_POST['zipCode'] ?? 'Vide') ;
$email = htmlspecialchars($_POST['email'] ?? 'Vide') ;
$searchGender = htmlspecialchars($_POST['searchGender'] ?? 'Vide') ;
$regexName = "/^[a-z ,.'-]+$/i";
$regexAge = "/^\d{1,2}$/";
$regexZipCode = "/^\d{5}$/";
$regexMail = "/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/";
$regexPassword = "/^(?=.*?[A-Z])(?=.*?[a-z]).{5,}$/";
$mailArray = ['julien@gmail.com', 'paul@gmail.com', 'habib@hotmail.fr'];

if (isset($_POST['submit'])) { //si submit est dans le post
    $count = 0;
    if (!isValid($regexName, $name)) { // si la regex n'est pas valide
        $errorName = 'Nom incorrect, exemple : Macron'; // mettre un message
        $count++; // incrémente un conter d'erreur
        $className = 'is-invalid';
    }
    if (!isValid($regexName, $firstname)) {
        $errorFirstname = 'Prénom incorrect, exemple : Emmanuel';
        $count++;
        $classFirstname = 'is-invalid';
    }
    if (!isValid($regexAge, $age)) {
        $errorAge = 'Age incorrect, exemple : 25';
        $count++;
        $classAge = 'is-invalid';
    }
    if (!isValid($regexZipCode, $zipCode)) {
        $errorZipCode = 'Code postal incorrect, exemple : 50310';
        $count++;
        $classZipCode = 'is-invalid';
    }
    if (!isValid($regexMail, $email)) {
        $errorMail = 'Mail incorrect, exemple : john@gmail.com';
        $count++;
        $classMail = 'is-invalid';
    } elseif (!mailExist($email, $mailArray)) {
        $errorMail = 'Ce mail est déja inscrit';
        $count++;
        $classMail = 'is-invalid';
    }
    if ($count == 0) { // le conteur est à 0
        header("Location: developpers.php?searchGender=$searchGender"); // change de page avec le bonne url pour récupéré en GET
    }
}

$pushToCookie = ['name', 'firstname', 'age', 'gender', 'zipCode', 'email', 'searchGender'];

if (!empty($_POST)) {
    foreach($pushToCookie as $key){
        $value = $_POST[$key];
        if (isset($value)) {
            setcookie($key, $value, time() + 24 * 60 * 60);
        }
    }
}

if (isset($_COOKIE["name"])) {
    header("Location: developpers.php?searchGender=$searchGender"); // change de page avec le bonne url pour récupéré en GET
    exit(); // stop le script
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
    <title>Formulaire</title>
</head>
<body>
    <h1 class="mb-5">BIENVENUE</h1>
    <div class="myForm">
        <form action="index.php" method="post" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control <?= $className ?? '' ?>" id="name" name="name" required value="<?= $_POST['name'] ?? '';?>" > <!-- si il ya le name dans POSt affiche le sinon met rien -->
            <div id="emailHelp" class="form-text"><?= $errorName ?? '' ?></div> <!-- affiche le message d'erreur -->
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control <?= $classFirstname ?? '' ?>" id="firstname" name="firstname" required value="<?= $_POST['firstname'] ?? '';?>">
            <div id="emailHelp" class="form-text"><?= $errorFirstname ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control <?= $classAge ?? '' ?>" id="age" name="age" required value="<?= $_POST['age'] ?? '';?>">
            <div id="emailHelp" class="form-text"><?= $errorAge ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Genre</label>
            <select id="gender" class="form-select <?= $classGender ?? '' ?>" name="gender" required>
                <option selected disabled>Veuillez choisir</option>
                <option>Homme</option>
                <option>Femme</option>
            </select>
            <div id="emailHelp" class="form-text"><?= $errorGender ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="zipCode" class="form-label">Code Postal</label>
            <input type="text" class="form-control <?= $classZipCode ?? '' ?>" id="zipCode" name="zipCode" aria-describedby="emailHelp" required value="<?= $_POST['zipCode'] ?? '';?>">
            <div id="emailHelp" class="form-text"><?= $errorZipCode ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse mail</label>
            <input type="email" class="form-control <?= $classMail ?? '' ?>" id="email" name="email" aria-describedby="emailHelp" required value="<?= $_POST['email'] ?? '';?>">
            <div id="emailHelp" class="form-text"><?= $errorMail ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="searchGender" class="form-label">Recherche</label>
            <select id="searchGender" class="form-select <?= $classSearchGender ?? '' ?>" name="searchGender" required>
                <option selected disabled>Veuillez choisir</option>
                <option>Homme</option>
                <option>Femme</option>
            </select>
            <div id="emailHelp" class="form-text"><?= $errorSearchGender ?? '' ?></div>
        </div>
        <button type="submit" class="btn btn-primary" id="btn" name="submit">Rencontrer nos célibataire</button>
        </form>
    </div>
</body>
</html>