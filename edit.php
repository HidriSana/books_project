<?php

// Connexion à la BDD
require_once('server.php');

// En-tête
$pageTitle = 'Modifier un livre';
$donkey = 'Donkey'; // A modifier   une fois que le login est géré ++++
$cart = 0;
include('header.php');

//Récupération des données en POST 
if (!empty($_POST)) {
    $bookTitle =  $_POST['title'];
    $authorFirstname = $_POST['firstname'];
    $authorLastname = $_POST['lastname'];
    $bookCategories = isset($_POST['category']) ? $_POST['category'] : [];

    $queryUpdateBookDetails = "UPDATE book AS b
    JOIN author AS a ON b.author_id = a.id
    JOIN book_category AS bc ON b.id = bc.book_id
    JOIN category AS c ON bc.category_id = c.id
    SET b.title = '$bookTitle', a.firstname = '$authorFirstname', a.lastname = '$authorLastname'
    WHERE b.id = " . $_GET['identifiant'];

    $updateBookDetails = $mysqli->query($queryUpdateBookDetails);
    if ($updateBookDetails) {

        $mysqli->query("DELETE FROM book_category WHERE book_id = " . $_GET['identifiant']);

        foreach ($bookCategories as $categoryId) {
            $mysqli->query("INSERT INTO book_category (book_id, category_id) VALUES (" . $_GET['identifiant'] . ", " . $categoryId . ")");
        }

        echo 'Vos modifications ont bien été enregistrées';
    } else {
        echo 'Échec de la mise à jour';
    }
}
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

//Récupération de toutes les catégories
$queryAllCategories =  $mysqli->query('SELECT * FROM category');

$allCategories = [];
if ($queryAllCategories->num_rows > 0) {
    while ($oneCategory = $queryAllCategories->fetch_assoc()) {
        $allCategories[] = $oneCategory;
    }
} else {
    die("Aucune catégorie trouvée");
}

$bookCategoriesQuery = $mysqli->query('SELECT category_id FROM book_category WHERE book_id = ' . $_GET["identifiant"]);
//Récupération des catégories déjà associées au livre
$bookCategories = [];
while ($categoryRow = $bookCategoriesQuery->fetch_assoc()) {
    $bookCategories[] = $categoryRow['category_id'];
}

// Affichage 
echo '<h2>' . "Modification du livre portant l'id numéro " . $i['id'] . '</h2>';
echo '<form action="" method="post">';
echo '<div><label for="title">Titre du livre: </label><input type="text" id="title" name="title" value="' . $i['title'] . '"></div>';
echo '<div><label for="firstname">Prénom de l\'auteur: </label><input type="text" id="firstname" name="firstname" value="' . $i['firstname'] . '"></div>';
echo '<div><label for="lastname">Nom de l\'auteur: </label><input type="text" id="lastname" name="lastname" value="' . $i['lastname'] . '"></div>';
echo '<fieldset><legend>Catégorie(s):</legend>';
echo '<div class="categories">';

// Affichage de toutes les catégories avec les cases cochées si elles sont associées au livre
foreach ($allCategories as $oneCategory) {
    $isChecked = in_array($oneCategory['id'], $bookCategories) ? 'checked' : '';
    echo '<label><input type="checkbox" name="category[]" value="' . $oneCategory['id'] . '" ' . $isChecked . '>' . $oneCategory['name'] . '</label><br>';
}

echo '</div>';
echo '</fieldset>';
echo '<input type="submit" value="Enregistrer les modifications">';
echo '</form>';

// Pied de page
include('footer.php');
