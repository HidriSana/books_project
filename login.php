<form action="" method="post">
    <div>
        <label for="login">Identifiant:</label>
        <input type="text" id="login" name="login" required>
    </div>
    <div>
        <button type="submit">Se connecter</button>
    </div>
</form>

<?php
var_dump($_POST);

$login = $_POST['login'];

if (empty($login)) {
    header('location: login.php');
    echo 'Vous devez être identifié pour accéder à cette page.';
} else {
    session_start();
    $_SESSION['login'] = $login;
    header('location: index.php');
}
