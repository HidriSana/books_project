<?php
// Header
$pageTitle = "S'enregistrer";
$donkey = 'Donkey'; // À modifier une fois que le login est géré
$cart = 0;
include('header.php');

// Variables récupérées depuis le formulaire
$login = $_POST['login'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Hash du mot de passe
$hashPassword = password_hash($password, PASSWORD_DEFAULT);

// Tableau pour stocker les erreurs de saisie
$inputErrors = [];

// Regex pour validation du login et du mot de passe
$loginRegex = "/^[a-z0-9]+$/"; // Regex sans espaces, sans majuscules et sans caractères spéciaux
$passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]+$/"; // Regex pour au moins une lettre en minuscule, au moins une lettre en majuscule, au moins un chiffre et au moins un caractère spécial

// Validation du login
if (empty($login)) {
    $inputErrors[] = 'Empty login';
    echo 'Vous devez saisir un login';
} else {
    $login = test_input($login);
    if (!preg_match($loginRegex, $login)) {
        $inputErrors[] = 'REGEX not matching';
        echo 'Votre login doit uniquement comporter des minuscules et des chiffres';
    }
    if (strlen($login) < 6 || strlen($login) > 12) {
        $inputErrors[] = 'Invalid login length';
        echo 'Votre login doit comporter entre 6 et 12 caractères';
    }
}

// Validation du mot de passe
if (empty($password)) {
    $inputErrors[] = 'Empty password';
    echo 'Vous devez saisir un mot de passe';
} else {
    $password = test_input($password);
    if (!preg_match($passwordRegex, $password)) {
        $inputErrors[] = 'REGEX not matching';
        echo 'Votre mot de passe doit comporter au moins une lettre en minuscule, une lettre en majuscule, un chiffre et un caractère spécial';
    }
    if (strlen($password) < 8 || strlen($password) > 18) {
        $inputErrors[] = 'Invalid password length';
        echo 'Votre mot de passe doit comporter entre 8 et 18 caractères';
    }
}

// Comparaison des mots de passe
if ($password !== $confirmPassword) {
    $inputErrors[] = 'Passwords not matching!';
    echo 'Les mots de passe ne sont pas identiques';
}

// Si aucune erreur, insertion dans la base de données
if (empty($inputErrors)) {
    $checkQuery = "SELECT COUNT(*) FROM user WHERE login = ?";
    $checkStatement = $mysqli->prepare($checkQuery);
    $checkStatement->bind_param('s', $login);
    $checkStatement->execute();
    $checkStatement->bind_result($count);
    $checkStatement->fetch();
    $checkStatement->close();

    if ($count > 0) {
        $inputErrors[] = 'Login already exists';
        echo 'Ce login est déjà utilisé. Veuillez en choisir un autre.';
    } else {
        $query = "INSERT INTO user (login, password) VALUES (?, ?)";
        $statement = $mysqli->prepare($query);
        $statement->bind_param('ss', $login, $hashPassword);
        $statement->execute();
        echo 'Votre compte a bien été créé';
    }
}
include('footer.php');
