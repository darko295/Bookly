<?php
session_start();
if (isset($_GET['reviewID'])) {
    $reviewID = $_GET['reviewID'];
    include "connection.php";
    $sql = "DELETE FROM review WHERE reviewID ='" . $reviewID . "'";

    if ($q = $mysqli->query($sql)) {
        echo "1";
    }
    $mysqli->close();
}