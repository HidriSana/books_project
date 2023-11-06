<?php
// Connexion à la BDD
require_once('server.php');

// Inclure l'en-tête
$pageTitle = 'Détails';
$donkey = 'Donkey'; // A modifier   une fois que le login est géré ++++
$cart = 0;
include('header.php');

// Récupération  des détails des livres par ID 

$queryBooksDetails = 'SELECT b.id, b.title, a.firstname, a.lastname, c.name AS `category`
FROM book b 
LEFT JOIN author a ON b.author_id = a.id
LEFT JOIN book_category bc ON b.id = bc.book_id
LEFT JOIN category c ON bc.category_id = c.id 
WHERE b.id = ' . $_GET["identifiant"];

$resultBooksDetails = $mysqli->query($queryBooksDetails);


if ($resultBooksDetails->num_rows > 0) {
    $i = $resultBooksDetails->fetch_assoc();
} else {
    die("Aucune ligne trouvée");
}
//Mise  en place du tableau d'affichage
var_dump($i);

echo '<table>';
echo '<tr><th>ID</th>';
echo '<th>Titre</th>';
echo '<th>Auteur</th>';
echo '<th>Catégorie</th></tr>';
echo '<tr><td>' . $i['id'] . '</td>';
echo '<td>' . $i['title'] . '</td>';
echo '<td>' . $i['firstname']  . ' ' . $i['lastname'] . '</td>';
echo '<td>' . $i['category'] . '</td></tr>';
echo '</table>';




// Inclure le pied de page
include('footer.php');
