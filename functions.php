<?php
function test_input($data)
{
    $data = trim($data);            // Suppression des espaces avant et après
    $data = stripslashes($data);    // Suppression des antislashs pour éviter l'échappement ou d'intérférer avec les balises HTML
    $data = htmlspecialchars($data); // Convertir les caractères spéciaux en entités HTML
    return $data;
}
