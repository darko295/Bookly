<?php
include(dirname(__FILE__) . "/../public/connection.php");

class review
{

    function getID($username)
    {
        global $mysqli;
        $sql = "SELECT * FROM user WHERE username='" . $username . "'";
        $rezultat = $mysqli->query($sql);
        $res = $rezultat->fetch_array();
        return $res;
    }

    public function addReview($bookID, $authorID, $review, $stars, $username)
    {
        global $mysqli;
        $row = $this->getID($username);
        $id = $row['userID'];
        $date = date("Y-m-d H:i:s");
        $stmt = $mysqli->prepare("INSERT INTO review (userID, bookID, authorID, reviewContent, reviewStars, reviewTime) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisds", $id, $bookID, $authorID, $review, $stars, $date);
        if ($stmt->execute()) {
            return true;

        } else {
            return false;
        }
    }

    public function getAll()
    {
        global $mysqli;
        $sql = "SELECT u.username, u.userID, b.bookTitle, b.bookID, a.authorID, a.name, a.surname, r.reviewID, r.reviewContent, r.reviewStars, r.reviewTime
                FROM author a JOIN book b ON a.authorID=b.authorID JOIN review r ON b.bookID=r.bookID JOIN user u ON u.userID=r.userID";
        if ($rezultat = $mysqli->query($sql)) {
            return $rezultat;
        }
        return null;
    }


    public function getLatest()
    {
        global $mysqli;
        $sql = "SELECT u.username, u.userID, b.bookTitle, a.name, a.surname, r.reviewID, r.reviewContent, r.reviewStars, r.reviewTime
                FROM author a JOIN book b ON a.authorID=b.authorID JOIN review r ON b.bookID=r.bookID JOIN user u ON u.userID=r.userID
                WHERE r.reviewID = (SELECT MAX(reviewID) FROM review WHERE  reviewStars != '-1')";
        if ($rezultat = $mysqli->query($sql)) {
            return $rezultat;
        }
        return null;
    }

    public function delete_review($review_id)
    {
        global $mysqli;
        $sql = "DELETE FROM review WHERE reviewID =". $review_id;

        if ($q = $mysqli->query($sql)) {
            echo "1";
        } else {
            echo "0";
        }

    }

}