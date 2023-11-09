<?php
// Header
$pageTitle = 'Se connecter';
$donkey = 'Donkey'; // À modifier une fois que le login est géré
$cart = 0;
include('header.php');
?>
<form action="" method="post" class="formLogin">
    <div>
        <label for="login">Login :</label>
        <input type="text" id="title" name="login" required>
    </div>
    <div>
        <label for="auhtor">Password :</label>
        <input type="password" id="password" name="password" required>
    </div>
    <input type="submit" value="Se connecter">
</form>
<p class='register'><a href="register.php">Je n'ai pas encore de compte</a></p>
<?php

/*var_dump($_POST);

$login = $_POST['login'];

if (empty($login)) {
    //header('location: login.php');
    echo 'Vous devez être identifié pour accéder à cette page.';
} else {
    session_start();
    $_SESSION['login'] = $login;
    //header('location: index.php');
}*/
