<?php
// Connection to db
require_once('server.php');

// Header
$pageTitle = 'Supprimer un livre';
$donkey = 'Donkey'; // A modifier   une fois que le login est géré ++++
$cart = 0;
include('header.php');

//Deleting a book 
$bookID = $_GET['identifiant'];
//deleting book in the relationship table before book table, otherwise, it's not deleting the book due to constraint
$deletingBookFromRelationTable = $mysqli->query("DELETE FROM book_category WHERE book_id = $bookID");
//Deleting book from book table
$bookDeletion = $mysqli->query("DELETE FROM book WHERE id = " . $_GET['identifiant']);

header('Location: /index.php');
echo '<p>Le livre a bien été supprimé</p>';
die;
include('footer.php');
