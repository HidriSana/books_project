if (!empty($_POST)) {
    $bookTitle =  $_POST['title'];
    $authorFirstname = $_POST['firstname'];
    $authorLastname = $_POST['lastname'];
    $bookCategory[] = $_POST['category'];

    $queryUpdateBookDetails = "UPDATE book AS b
    JOIN author AS a ON b.author_id = a.id
    JOIN book_category AS bc ON b.id = bc.book_id
    JOIN category AS c ON bc.category_id = c.id
    SET b.title = '$bookTitle', a.firstname = '$authorFirstname', a.lastname = '$authorLastname'
    WHERE b.id = ".$_GET['identifiant'];

    $updateBookDetails = $mysqli->query($queryUpdateBookDetails);
}
