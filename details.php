<?php
// En-tête
$pageTitle = 'Détails';
$donkey = 'Donkey'; // A modifier   une fois que le login est géré ++++
$cart = 0;
include('header.php');

// Requête préparée pour récupérer les détails d'un livre par ID
$bookId = isset($_GET['identifiant']) ? $_GET['identifiant'] : null;
if ($bookId) {
    $queryBooksDetails = 'SELECT b.id, b.title, a.firstname, a.lastname, c.name AS `category`
    FROM book b 
    LEFT JOIN author a ON b.author_id = a.id
    LEFT JOIN book_category bc ON b.id = bc.book_id
    LEFT JOIN category c ON bc.category_id = c.id 
    WHERE b.id = ?';

    $statement = $mysqli->prepare($queryBooksDetails);

    if ($statement) {
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $resultBooksDetails = $statement->get_result();

        $categories = [];
        if ($resultBooksDetails->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>ID</th>';
            echo '<th>Titre</th>';
            echo '<th>Auteur</th>';
            echo '<th>Catégorie</th></tr>';

            $i = $resultBooksDetails->fetch_assoc();
            echo '<tr><td>' . $i['id'] . '</td>';
            echo '<td>' . $i['title'] . '</td>';
            echo '<td>' . $i['firstname']  . ' ' . $i['lastname'] . '</td>';
            echo '<td>';
            //Getting  the first eelement of category ,didn't work otherwise, in the loop below. It would bring starting by the second element
            $categories[] = $i['category'];

            while ($i = $resultBooksDetails->fetch_assoc()) {
                $categories[] = $i['category'];
            };
            foreach ($categories as $category) {
                echo $category . '</br>';
            }

            echo '</td></tr>';
            echo '</table>';
        } else {
            die("Aucune ligne trouvée");
        }
        $statement->close();
    }
}

// Pied de page
include('footer.php');
