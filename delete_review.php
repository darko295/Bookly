<?php
session_start();
include "connection.php";

if (isset($_GET['reviewID'])) {
    $reviewID = $_GET['reviewID'];
    $sql = "DELETE FROM review WHERE reviewID ='" . $reviewID . "'";

    if ($q = $mysqli->query($sql)) {
        echo "1";
    }else{

        echo "0";
    }
    $mysqli->close();
}