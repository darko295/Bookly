<?php
include "connection.php";

    function add_to_wishlist($user_id, $author_id, $book_id){
        global $mysqli;
        $sql = "INSERT INTO wishlist (userID, authorID, bookID) VALUES ('" . $user_id . "','" . $author_id . "','" . $book_id . "')";

        if ($mysqli->query($sql)) {
            echo "1";
        } else {
            echo "Error. You may want to add item that already exist in your wishlist.";
        }
    }


if (isset ($_POST["action"]) && isset($_POST["user_id"]) && isset($_POST["author_id"]) && isset($_POST['book_id'])){

    $user_id = (int) $_POST['user_id'];
    $author_id = (int) $_POST['author_id'];
    $book_id = (int) $_POST['book_id'];

    switch ($_POST["action"]){

        case "wishlist" :
            add_to_wishlist($user_id, $author_id, $book_id);
            break;

    }




}else{
    echo "<script> alert('Nisu GETavljeni svi parametri')</script>";

}
