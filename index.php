<?php

/************************Link to database************/

$serverName = 'localhost';
$userName = 'root';
$serverPassword = '';
$dbName = 'the_library_factory';

$mysqli = new mysqli($serverName, $userName, $serverPassword, $dbName);

//Connexion check

if ($mysqli->connect_error) {
    die("Connexion failed: " . $mysqli->connect_error);
}

/*********Affichage de la liste des livres et de leurs auteurs **********/

$sqlBooksAndAuthors = 'SELECT b.title, a.firstname, a.lastname FROM book b LEFT JOIN author a ON b.author_id = a.id';
$resultBooksAndAuthors = $mysqli->query($sqlBooksAndAuthors);


$booksAndAuthors = [];

if ($resultBooksAndAuthors->num_rows > 0) {
    while ($row = $resultBooksAndAuthors->fetch_assoc()) {
        $booksAndAuthors[] = $row;
    }
} else {
    echo 'Aucun résultat trouvé';
}
echo "<table><tr><th>Titre du livre</th><th>Prénom de l'auteur</th><th>Nom de l'auteur</th><th>Actions</th></tr>";
foreach ($booksAndAuthors as $bookAndAuthor) {
    $title = $bookAndAuthor['title'];
    $authorFirstname = $bookAndAuthor['firstname'];
    $authorLastname = $bookAndAuthor['lastname'];
    echo '<tr><td>' . $title . '</td>' . $authorFirstname . ' ' . $authorLastname . '</br>';
}

