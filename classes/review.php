<?php
include(dirname(__FILE__) . "/../connection.php");

class review
{

    function getID($username)
    {
        global $mysqli;

        $sql = "SELECT * FROM user WHERE username='" . $username . "'";

        $rezultat = $mysqli->query($sql);

        $mysqli->close();
        $res = $rezultat->fetch_array();
        return $res;
    }


    public function addReview($bookID, $authorID, $review, $stars, $username)
    {
        global $mysqli;
        $row = $this->getID($username);
        $id = $row['userID'];
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO review (userID, bookID, authorID, reviewContent, reviewStars, reviewTime) VALUES ('" . $id . "','" . $bookID . "', '" . $authorID . "','" . $review . "', '" . $stars . "','" . $date . "')";
        if ($mysqli->query($sql)) {
            return true;

        } else {
            return false;
        }
    }

    public function getAll()
    {
        include(dirname(__FILE__) . "/../connection.php");
        $sql = "SELECT u.username, u.userID, b.bookTitle, a.name, a.surname, r.reviewID, r.reviewContent, r.reviewStars, r.reviewTime
                FROM author a JOIN book b ON a.authorID=b.authorID JOIN review r ON b.bookID=r.bookID JOIN user u ON u.userID=r.userID";
        if ($rezultat = $mysqli->query($sql)) {
            $mysqli->close();
            return $rezultat;

        }
        $mysqli->close();
        return null;
    }

    public function getStats()
    {
        global $mysqli;
        $sql = "SELECT (SELECT COUNT(*) FROM book) AS bookCount, (SELECT COUNT(*) FROM   user) AS userCount,(SELECT COUNT(*) FROM   review) AS reviewCount FROM DUAL";
        if ($rezultat = $mysqli->query($sql)) {
            $mysqli->close();
            return $rezultat;

        }
        $mysqli->close();
        return null;


    }

    public function getLatest()
    {
       // global $mysqli;
        include(dirname(__FILE__) . "/../connection.php");

        $sql = "SELECT u.username, u.userID, b.bookTitle, a.name, a.surname, r.reviewID, r.reviewContent, r.reviewStars, r.reviewTime
                FROM author a JOIN book b ON a.authorID=b.authorID JOIN review r ON b.bookID=r.bookID JOIN user u ON u.userID=r.userID
                WHERE r.reviewID = (SELECT MAX(reviewID) FROM review WHERE  reviewStars != '-1')";
        if ($rezultat = $mysqli->query($sql)) {
            $mysqli->close();
            return $rezultat;

        }
        $mysqli->close();
        return null;

    }

}