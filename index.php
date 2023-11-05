<?php
//Connexion à la BDD
require_once('server.php');

// Inclure l'en-tête
$pageTitle = 'Accueil';
$donkey = 'Donkey';
$cart = 0;
include('header.php');

// Récupération des livres et de leurs auteurs
$sqlBooksAndAuthors = 'SELECT b.id, b.title, a.firstname, a.lastname FROM book b LEFT JOIN author a ON b.author_id = a.id';
$resultBooksAndAuthors = $mysqli->query($sqlBooksAndAuthors);

$booksAndAuthors = [];

if ($resultBooksAndAuthors->num_rows > 0) {
    while ($row = $resultBooksAndAuthors->fetch_assoc()) {
        $booksAndAuthors[] = $row;
    }
} else {
    die("Aucune ligne trouvée");
}


// Affichage de la liste des livres et de leurs auteurs
echo '<table style="border-collapse: collapse; width: 50%; border: 1px solid black">';
echo '<tr><th style="text-align: left; border: 1px solid black">Titre du livre</th>';
echo '<th style="text-align: center; border: 1px solid black">Auteur</th>';
echo '<th style="text-align: center; border: 1px solid black">Actions</th>';
echo '<th style="text-align: center; border: 1px solid black">Administration</th></tr>';

foreach ($booksAndAuthors as $bookAndAuthor) {
    $title = $bookAndAuthor['title'];
    $authorName = $bookAndAuthor['firstname'] . ' ' . $bookAndAuthor['lastname'];
    $bookId = $bookAndAuthor['id'];

    echo '<tr><td style="border: 1px solid black">' . $title . '</td>';
    echo '<td style="text-align: center; border: 1px solid black">' . $authorName . '</td>';
    echo '<td style="text-align: center; border: 1px solid black">';
    echo '<a href="details.php?identifiant=' . $bookId . '" target="_blank">Détails</a><br>';
    echo '<a href="cart.php" target="_blank">Acheter</a></td>';
    echo '<td style="text-align: center; border: 1px solid black">';
    echo '<a href="edit.php?identifiant=' . $bookId . '" target="_blank">Modifier</a><br>';
    echo '<a href="delete.php?identifiant=' . $bookId . '" target="_blank">Supprimer</a></td></tr>';
}

echo '</table>';
echo '<a href="add.php" target="_blank"><p>Ajouter un livre</p></a>';

// Inclure le pied de page
include('footer.php');
