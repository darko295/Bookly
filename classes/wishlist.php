<?php
include(dirname(__FILE__) . "/../public/connection.php");

class wishlist
{
    public function add_new_item ($user_id, $author_id, $book_id){

        global $mysqli;
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO wishlist (userID, authorID, bookID, dateAdded) VALUES ('" . $user_id . "','" . $author_id . "','" . $book_id . "','".$date."')";

        if ($mysqli->query($sql)) {
            echo "1";
        } else {
            echo "Error";
        }

    }
}