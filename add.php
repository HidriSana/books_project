<?php
// En-tête
$pageTitle = 'Ajouter un livre';
$donkey = 'Donkey'; // À modifier une fois que le login est géré ++++++++++++
$cart = 0;
include('header.php');

if (!empty($_POST)) {
    $bookTitle = $_POST['title'];
    $authorFirstname = $_POST['firstname'];
    $authorLastname = $_POST['lastname'];
    $bookCategories = $_POST['category'];

    // Utilisation de requêtes préparées pour insérer l'auteur s'il n'existe pas
    $queryCreateAuthor = "INSERT INTO author (firstname, lastname) VALUES (?, ?)";
    $stmtAuthor = $mysqli->prepare($queryCreateAuthor);

    if ($stmtAuthor) {
        $stmtAuthor->bind_param('ss', $authorFirstname, $authorLastname);
        $stmtAuthor->execute();

        // Récupérer l'ID de l'auteur nouvellement inséré
        $newAuthorID = $mysqli->insert_id;
        $stmtAuthor->close();

        // Utilisation de requêtes préparées pour insérer le livre en utilisant l'ID de l'auteur
        $queryCreateBookDetails = "INSERT INTO book (title, author_id) VALUES (?, ?)";
        $stmtBook = $mysqli->prepare($queryCreateBookDetails);

        if ($stmtBook) {
            $stmtBook->bind_param('si', $bookTitle, $newAuthorID);
            $stmtBook->execute();


            $newBookID = $mysqli->insert_id;
            $stmtBook->close();

            // Utilisation de requêtes préparées pour insérer les relations livre-catégorie
            $queryInsertCategory = "INSERT INTO book_category (book_id, category_id) VALUES (?, ?)";
            $stmtCategory = $mysqli->prepare($queryInsertCategory);

            if ($stmtCategory) {
                foreach ($bookCategories as $categoryId) {
                    $stmtCategory->bind_param('ii', $newBookID, $categoryId);
                    $stmtCategory->execute();
                }
                $stmtCategory->close();
            } else {
                echo 'Échec de l\'ajout des catégories.';
            }

            echo 'Le nouveau livre a été ajouté avec succès.';
        } else {
            echo 'Échec de l\'ajout du nouveau livre.';
        }
    } else {
        echo 'Échec de l\'ajout de l\'auteur.';
    }
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

echo '<h2>Ajouter un nouveau livre</h2>';
echo '<form action="" method="post">';
echo '<div><label for="title">Titre du livre: </label><input type="text" id="title" name="title"></div>';
echo '<div><label for="firstname">Prénom de l\'auteur: </label><input type="text" id="firstname" name="firstname"></div>';
echo '<div><label for "lastname">Nom de l\'auteur: </label><input type="text" id="lastname" name="lastname"></div>';
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

//header('Location: /index.php');
// Pied de page
include('footer.php');
