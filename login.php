<form action="" method="post">
    <div>
        <label for="login">Login :</label>
        <input type="text" id="title" name="login" required>
    </div>
    <div>
        <label for="auhtor">Password :</label>
        <input type="password" id="password" name="password" required>
    </div>
    <input type"submit" value="Se connecter">
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
