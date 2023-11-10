<?php
// Header
$pageTitle = "S'enregistrer'";
$donkey = 'Donkey'; // À modifier une fois que le login est géré
$cart = 0;
include('header.php');
?>

<form action="saveRegistration.php" method="post" class="formLogin">
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
include('footer.php');
