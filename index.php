<?php
// Connection to DB
require_once('server.php');

// Header
$pageTitle = 'Accueil';
$donkey = 'Donkey';
$cart = 0;
include('header.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';

// Prepared request
$queryBooksAndAuthors = "SELECT b.id, b.title, a.firstname, a.lastname 
FROM book b 
LEFT JOIN author a ON b.author_id = a.id
WHERE b.title LIKE ? OR a.firstname LIKE ? OR a.lastname LIKE ?";

if ($statement = $mysqli->prepare($queryBooksAndAuthors)) {
    $param = "%" . $query . "%";
    $statement->bind_param("sss", $param, $param, $param);

    $statement->execute();

    $resultBooksAndAuthors = $statement->get_result();
    $booksAndAuthors = $resultBooksAndAuthors->fetch_all(MYSQLI_ASSOC);

    $statement->close();
} else {
    die("Erreur de requête préparée");
}

//Displaying books and authors 
echo '<table>';
echo '<tr><th>Titre du livre</th>';
echo '<th>Auteur</th>';
echo '<th>Actions</th>';
echo '<th>Administration</th></tr>';

foreach ($booksAndAuthors as $bookAndAuthor) {
    $title = $bookAndAuthor['title'];
    $authorName = $bookAndAuthor['firstname'] . ' ' . $bookAndAuthor['lastname'];
    $bookId = $bookAndAuthor['id'];

    echo '<tr><td>' . htmlspecialchars($title) . '</td>';
    echo '<td>' . htmlspecialchars($authorName) . '</td>';
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
