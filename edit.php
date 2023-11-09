<?php
// En-tête
$pageTitle = 'Modifier un livre';
$donkey = 'Donkey'; // À modifier une fois que le login est géré ++++
$cart = 0;
include('header.php');

// Récupération de l'identifiant du livre depuis les paramètres GET
$bookId = isset($_GET['identifiant']) ? $_GET['identifiant'] : null;

if ($bookId) {
    // Vérification si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données en POST
        $bookTitle = $_POST['title'];
        $authorFirstname = $_POST['firstname'];
        $authorLastname = $_POST['lastname'];
        $bookCategories = isset($_POST['category']) ? $_POST['category'] : [];

        // Utilisation d'une requête préparée pour la mise à jour
        $queryUpdateBookDetails = "UPDATE book AS b
        JOIN author AS a ON b.author_id = a.id
        SET b.title = ?, a.firstname = ?, a.lastname = ?
        WHERE b.id = ?";

        $stmt = $mysqli->prepare($queryUpdateBookDetails);

        if ($stmt) {
            $stmt->bind_param('sssi', $bookTitle, $authorFirstname, $authorLastname, $bookId);
            $stmt->execute();

            // Suppression des anciennes catégories associées
            $mysqli->query("DELETE FROM book_category WHERE book_id = $bookId");

            // Ajout des nouvelles catégories
            foreach ($bookCategories as $categoryId) {
                $mysqli->query("INSERT INTO book_category (book_id, category_id) VALUES ($bookId, $categoryId)");
            }

            $stmt->close();

            echo 'Vos modifications ont bien été enregistrées';
        } else {
            echo 'Échec de la mise à jour';
        }
    }

    // Récupération des détails du livre
    $queryBooksDetails = 'SELECT b.id, b.title, a.firstname, a.lastname, c.name AS `category`
    FROM book b 
    LEFT JOIN author a ON b.author_id = a.id
    LEFT JOIN book_category bc ON b.id = bc.book_id
    LEFT JOIN category c ON bc.category_id = c.id 
    WHERE b.id = ?';

    $stmt = $mysqli->prepare($queryBooksDetails);

    if ($stmt) {
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        $resultBooksDetails = $stmt->get_result();

        if ($resultBooksDetails->num_rows > 0) {
            $row = $resultBooksDetails->fetch_assoc();
        } else {
            die("Aucune ligne trouvée");
        }

        $stmt->close();
    }

    // Récupération de toutes les catégories
    $queryAllCategories = $mysqli->query('SELECT * FROM category');

    $allCategories = [];

    if ($queryAllCategories->num_rows > 0) {
        while ($oneCategory = $queryAllCategories->fetch_assoc()) {
            $allCategories[] = $oneCategory;
        }
    } else {
        die("Aucune catégorie trouvée");
    }

    // Récupération des catégories déjà associées au livre
    $bookCategoriesQuery = $mysqli->prepare('SELECT category_id FROM book_category WHERE book_id = ?');
    $bookCategoriesQuery->bind_param('i', $bookId);
    $bookCategoriesQuery->execute();

    $bookCategoriesResult = $bookCategoriesQuery->get_result();
    $bookCategories = [];

    while ($categoryRow = $bookCategoriesResult->fetch_assoc()) {
        $bookCategories[] = $categoryRow['category_id'];
    }

    // Affichage
    echo '<h2>' . "Modification du livre portant l'ID numéro " . $row['id'] . '</h2>';
    echo '<form action="" method="post">';
    echo '<div><label for="title">Titre du livre: </label><input type="text" id="title" name="title" value="' . htmlspecialchars($row['title']) . '"></div>';
    echo '<div><label for="firstname">Prénom de l\'auteur: </label><input type="text" id="firstname" name="firstname" value="' . htmlspecialchars($row['firstname']) . '"></div>';
    echo '<div><label for="lastname">Nom de l\'auteur: </label><input type="text" id="lastname" name="lastname" value="' . htmlspecialchars($row['lastname']) . '"></div>';
    echo '<fieldset><legend>Catégorie(s):</legend>';
    echo '<div class="categories">';

    // Affichage de toutes les catégories avec les cases cochées si elles sont associées au livre
    foreach ($allCategories as $oneCategory) {
        $isChecked = in_array($oneCategory['id'], $bookCategories) ? 'checked' : '';
        echo '<label><input type="checkbox" name="category[]" value="' . $oneCategory['id'] . '" ' . $isChecked . '>' . htmlspecialchars($oneCategory['name']) . '</label><br>';
    }

    echo '</div>';
    echo '</fieldset>';
    echo '<input type="submit" value="Enregistrer les modifications">';
    echo '</form>';
} else {
    echo "Identifiant de livre non spécifié.";
}

// Pied de page
include('footer.php');
