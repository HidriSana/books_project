<?php
// Connexion à la BDD
require_once('server.php');

// Inclure l'en-tête
$pageTitle = 'Détails';
$donkey = 'Donkey'; // A modifier   une fois que le login est géré ++++
$cart = 0;
include('header.php');

// Récupération  des détails des livres par ID 

$sqlBooksDetails = 'SELECT b.id, b.title, a.firstname, a.lastname, c.name AS `category`
FROM book b 
LEFT JOIN author a ON b.author_id = a.id
LEFT JOIN book_category bc ON b.id = bc.book_id
LEFT JOIN category c ON bc.category_id = c.id 
WHERE b.id = ' . $_GET["identifiant"];

$resultBooksDetails = $mysqli->query($sqlBooksDetails);


if ($resultBooksDetails->num_rows > 0) {
    $i = $resultBooksDetails->fetch_assoc();
} else {
    die("Aucune ligne trouvée");
}
//Mise  en place du tableau d'affichage

echo '<table style="border-collapse: collapse; width: 50%; border: 1px solid black">';
echo '<tr><th style="text-align: left; border: 1px solid black">ID</th>';
echo '<th style="text-align: center; border: 1px solid black">Titre</th>';
echo '<th style="text-align: center; border: 1px solid black">Auteur</th>';
echo '<th style="text-align: center; border: 1px solid black">Catégorie</th></tr>';
echo '<tr><td style="border: 1px solid black">' . $i['id'] . '</td>';
echo '<td style="text-align: center; border: 1px solid black">' . $i['title'] . '</td>';
echo '<td style="text-align: center; border: 1px solid black">' . $i['firstname']  . ' ' . $i['lastname'] . '</td>';
echo '<td style="text-align: center; border: 1px solid black">' . $i['category'] . '</td></tr>';
echo '</table>';




// Inclure le pied de page
include('footer.php');
