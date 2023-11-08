
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
