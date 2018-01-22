<?php
include(dirname(__FILE__)."/../connection.php");

class book
{

    function doesItExist($title)
    {
        global $mysqli;
        $sql = "SELECT * FROM book WHERE bookTitle='" . $title . "'";
        $rezultat = $mysqli->query($sql);
        if ($rezultat->num_rows == 0) {
            return 0;
        } else {
            $res = $rezultat->fetch_array();
            return $res["bookID"];
        }
        $mysqli->close();
    }


    public function addBookIfDoesntExist($title, $id)
    {
        global $mysqli;
        $id_book = $this->doesItExist($title);
        if ($id_book == 0) {
            $sql = "INSERT INTO book (bookTitle, authorID) VALUES ('" . $title . "','" . $id . "')";
            if ($mysqli->query($sql)) {
                return mysqli_insert_id($mysqli);

            } else {

                echo "Greska kod ubacivanja knjige";
            }

        } else {
            return $id_book;

        }


    }
}