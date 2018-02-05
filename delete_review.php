<?php
session_start();
include "connection.php";
include "classes/review.php";
$review = new review();
if (isset($_GET['reviewID'])) {
    $reviewID = $_GET['reviewID'];
    $review->delete_review($reviewID);
}