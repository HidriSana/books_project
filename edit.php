<?php

// Connexion à la BDD
require_once('server.php');

// En-tête
$pageTitle = 'Modifier un livre';
$donkey = 'Donkey'; // A modifier   une fois que le login est géré ++++
$cart = 0;
include('header.php');

//Récupération des donées en POST 
/*if (!empty($_POST)){
    $bookTitle =  $_POST['title'];
}
//$sqlBooksEdit = 'UPDATE book SET `title`';*/
//Récupération du livre , de son auteur et de sa catégorie  de la BDD
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
//Récupération de toutes les catégories
$queryAllCategories =  $mysqli->query('SELECT `name` FROM category');

$allCategories = [];
if ($queryAllCategories->num_rows > 0) {
    while ($category = $queryAllCategories->fetch_assoc()) {
        $allCategories[] = $category;
    }
} else {
    die("Aucune catégorie trouvée");
}
var_dump($allCategories);
/*
   $i['title'] $i['firstname'] $i['lastname'] $i['category']
*/

echo '<h2>' . "Modification du livre portant l'id numéro " . $i['id'] . '</h2>';

echo '<form>';
echo '<div><label for="title">Titre du livre: </label><input type="text" id="title" name="title" value = "' . $i['title'] . '"></div>';
echo '<div><label for="author">Auteur: </label><input type="text" id="author" name="auhtor" value = "' . $i['firstname'] . $i['lastname'] . '"></div>';
echo '<div><label for="category">Catégorie(s): </label><input type="checkbox"  id="category">';

echo '</div>';
echo '</form>';
