<?php
//Connexion à la BDD
require_once('server.php');

// Inclure l'en-tête
$pageTitle = 'Accueil';
$donkey = 'Donkey';
$cart = 0;
include('header.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';
// Récupération des livres et de leurs auteurs
$queryBooksAndAuthors = "SELECT b.id, b.title, a.firstname, a.lastname 
FROM book b 
LEFT JOIN author a ON b.author_id = a.id
WHERE b.title LIKE '%$query%' OR a.firstname LIKE '%$query%' OR a.lastname LIKE '%$query'";

$resultBooksAndAuthors = $mysqli->query($queryBooksAndAuthors);

$booksAndAuthors = [];

if ($resultBooksAndAuthors->num_rows > 0) {
    while ($row = $resultBooksAndAuthors->fetch_assoc()) {
        $booksAndAuthors[] = $row;
    }
} else {
    die("Aucune ligne trouvée");
}


// Affichage de la liste des livres et de leurs auteurs
echo '<table>';
echo '<tr><th>Titre du livre</th>';
echo '<th>Auteur</th>';
echo '<th>Actions</th>';
echo '<th>Administration</th></tr>';

foreach ($booksAndAuthors as $bookAndAuthor) {
    $title = $bookAndAuthor['title'];
    $authorName = $bookAndAuthor['firstname'] . ' ' . $bookAndAuthor['lastname'];
    $bookId = $bookAndAuthor['id'];

    echo '<tr><td>' . $title . '</td>';
    echo '<td>' . $authorName . '</td>';
    echo '<td>';
    echo '<a href="details.php?identifiant=' . $bookId . '" target="_blank">Détails</a><br>';
    echo '<a href="cart.php" target="_blank">Acheter</a></td>';
    echo '<td>';
    echo '<a href="edit.php?identifiant=' . $bookId . '" target="_blank">Modifier</a><br>';
    echo '<a href="delete.php?identifiant=' . $bookId . '" target="_blank">Supprimer</a></td></tr>';
}

echo '</table>';
echo '<a href="add.php" target="_blank"><p>Ajouter un livre</p></a>';

// Inclure le pied de page
include('footer.php');
