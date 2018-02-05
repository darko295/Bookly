<?php
session_start();
include "classes/user.php";
$user = new user();
if (!isset($_SESSION['username'])) {
    header('index.php');
}

if (isset($_GET["review_button"])) {
    if (!isset ($_GET["title"]) || !isset($_GET["author_name"]) || !isset($_GET["author_surname"]) || !isset($_GET["review_text"]) || !isset($_GET["stars_rating"])) {

        echo "Missing values";

    } else {
        $title = $_GET["title"];
        $name = $_GET["author_name"];
        $surname = $_GET["author_surname"];
        $review_text = $_GET["review_text"];
        $review_stars = $_GET["stars_rating"];
        $username = $_SESSION['username'];

        include "classes/author.php";
        include "classes/book.php";
        include "classes/review.php";

        $author = new author();
        $new_author_id = $author->addAuthorIfDoesntExist($name, $surname);

        $book = new book();
        $new_book_id = $book->addBookIfDoesntExist($title, $new_author_id);

        $review = new review();
        if ($review->addReview($new_book_id, $new_author_id, $review_text, $review_stars, $username)) {
            ?>
            <script>
                window.location.href = "bookly.php";
                alert("Uspesno ubacen utisak!");
            </script>
            <?php
        }
    }
}
?>