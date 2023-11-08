<?php
// Connection to db
require_once('server.php');

// Header
$pageTitle = 'Supprimer un livre';
$donkey = 'Donkey'; // À modifier une fois que le login est géré ++++
$cart = 0;
include('header.php');

// Suppression d'un livre
if (isset($_GET['identifiant'])) {
    // Récupération de l'identifiant du livre
    $bookID = $_GET['identifiant'];

    // Utilisation de requêtes préparées pour la suppression
    $queryDeleteBookCategory = "DELETE FROM book_category WHERE book_id = ?";
    $stmt1 = $mysqli->prepare($queryDeleteBookCategory);

    if ($stmt1) {
        $stmt1->bind_param('i', $bookID);
        $stmt1->execute();
        $stmt1->close();
    } else {
        echo "Échec de la suppression des relations livre-catégorie.";
    }

    $queryDeleteBook = "DELETE FROM book WHERE id = ?";
    $stmt2 = $mysqli->prepare($queryDeleteBook);

    if ($stmt2) {
        $stmt2->bind_param('i', $bookID);
        $stmt2->execute();
        $stmt2->close();
    } else {
        echo "Échec de la suppression du livre.";
    }

    echo '<p>Le livre a bien été supprimé.</p>';
} else {
    echo "Identifiant de livre non spécifié.";
}

header('Location: /index.php');
include('footer.php');
