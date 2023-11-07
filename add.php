<?php
// Connexion à la BDD
require_once('server.php');

// En-tête
$pageTitle = 'Ajouter un livre';
$donkey = 'Donkey'; // À modifier une fois que le login est géré
$cart = 0;
include('header.php');

if (!empty($_POST)) {
    $bookTitle = $_POST['title'];
    $authorFirstname = $_POST['firstname'];
    $authorLastname = $_POST['lastname'];
    $bookCategories = $_POST['category'];

    // Insérer l'auteur s'il n'existe pas
    $queryCreateAuthor = "INSERT INTO author (firstname, lastname) VALUES ('$authorFirstname', '$authorLastname')";
    $createAuthor = $mysqli->query($queryCreateAuthor);

    if ($createAuthor) {
        // Récupérer l'ID de l'auteur nouvellement inséré
        $newAuthorID = $mysqli->insert_id;

        // Insérer le livre en utilisant l'ID de l'auteur
        $queryCreateBookDetails = "INSERT INTO book (title, author_id) VALUES ('$bookTitle', $newAuthorID)";
        $createBookDetails = $mysqli->query($queryCreateBookDetails);

        if ($createBookDetails) {
            $newBookID = $mysqli->insert_id;

            foreach ($bookCategories as $categoryId) {
                $mysqli->query("INSERT INTO book_category (book_id, category_id) VALUES ($newBookID, $categoryId)");
            }

            echo 'Le nouveau livre a été ajouté avec succès.';
        } else {
            echo 'Échec de l\'ajout du nouveau livre.';
        }
    } else {
        echo 'Échec de l\'ajout de l\'auteur.';
    }
}

$queryAllCategories = $mysqli->query('SELECT * FROM category');

$allCategories = [];
if ($queryAllCategories->num_rows > 0) {
    while ($oneCategory = $queryAllCategories->fetch_assoc()) {
        $allCategories[] = $oneCategory;
    }
} else {
    die("Aucune catégorie trouvée");
}

echo '<h2>Ajouter un nouveau livre</h2>';
echo '<form action="" method="post">';
echo '<div><label for="title">Titre du livre: </label><input type="text" id="title" name="title"></div>';
echo '<div><label for="firstname">Prénom de l\'auteur: </label><input type="text" id="firstname" name="firstname"></div>';
echo '<div><label for="lastname">Nom de l\'auteur: </label><input type="text" id="lastname" name="lastname"></div>';
echo '<fieldset><legend>Catégorie(s):</legend>';
echo '<div class="categories">';

// Affichage de toutes les catégories avec les cases cochées si elles sont associées au livre
foreach ($allCategories as $oneCategory) {
    echo '<label><input type="checkbox" name="category[]" value="' . $oneCategory['id'] . '"> ' . $oneCategory['name'] . '</label><br>';
}

echo '</div>';
echo '</fieldset>';
echo '<input type="submit" value="Ajouter le livre">';
echo '</form>';

// Pied de page
include('footer.php');
