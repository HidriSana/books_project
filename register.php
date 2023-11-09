<?php
// Header
$pageTitle = "S'enregistrer'";
$donkey = 'Donkey'; // À modifier une fois que le login est géré
$cart = 0;
include('header.php');
?>

<form action="" method="post" class="formLogin">
    <div>
        <label for="login">Identifiant :</label>
        <input type="text" id="login" name="login" required>
    </div>
    <div>
        <label for="password">Définition du mot de passe :</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="confirmPassword">Confirmation du mot de passe :</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
    </div>
    <input type="submit" value="Créer mon compte">
</form>
<p class='register'><a href="register.php">Je n'ai pas encore de compte</a></p>
<?php
$login = $_POST['login'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$hash = password_hash($password, PASSWORD_DEFAULT);
$inputErrors = [];

if (!empty($_POST)) {;
    if (empty($login)) {
        echo 'Vous devez saisir un login';
        $inputErrors[] = 'Champ login vide';
    } else {
        $login = test_input($login);
        if (!preg_match("^[a-z0-9]+$", $login)) {
            echo 'Votre login doit uniquement comporter des minuscules et des chiffres';
            $inputErrors[] = 'Champ login vide';
        }
    }
    /*

Vérification du password ici


*/
    if ($password === $confirmPassword) {
        $query = "INSERT INTO user (login, password) VALUES (?, ?)";
        $statement = $mysqli->prepare($query);
        $statement->bind_param('ss', $login, $hash);
        $statement->execute();
        echo 'Votre compte a bien été créé';
    } else {
        echo 'Les mots de passe ne sont pas identiques';
    }
}
?>